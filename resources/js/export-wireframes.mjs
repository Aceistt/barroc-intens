
import fs from 'node:fs/promises';
import path from 'node:path';
import {
    parseWireDSL,
    generateIR,
    calculateLayout,
    renderToSVG,
} from '@wire-dsl/engine';
import { exportPNG } from '@wire-dsl/exporters';

const root = process.cwd();
const inputDir = path.join(root, 'wireframes');
const outputDir = path.join(root, 'wireframes-png');

async function findWireFiles(directory) {
    const files = [];

    for (const entry of await fs.readdir(directory, {
        withFileTypes: true,
    })) {
        const fullPath = path.join(directory, entry.name);

        if (entry.isDirectory()) {
            files.push(...await findWireFiles(fullPath));
        } else if (
            entry.isFile() &&
            entry.name.toLowerCase().endsWith('.wire')
        ) {
            files.push(fullPath);
        }
    }

    return files;
}

async function main() {
    await fs.mkdir(outputDir, { recursive: true });

    const files = await findWireFiles(inputDir);

    if (files.length === 0) {
        throw new Error('Geen .wire-bestanden gevonden.');
    }

    let success = 0;
    let failed = 0;

    console.log(`\nGevonden: ${files.length} wireframes\n`);

    for (const file of files) {
        const relativePath = path.relative(inputDir, file);
        const outputPath = path.join(
            outputDir,
            relativePath.replace(/\.wire$/i, '.png')
        );

        try {
            const source = await fs.readFile(file, 'utf8');

            const ast = parseWireDSL(source);
            const ir = generateIR(ast);
            const layout = calculateLayout(ir);
            const svg = renderToSVG(ir, layout);

            await fs.mkdir(path.dirname(outputPath), {
                recursive: true,
            });

            await exportPNG(svg, outputPath);

            console.log(`OK  ${relativePath}`);
            success++;
        } catch (error) {
            console.error(`FOUT ${relativePath}`);
            console.error(error.message);
            failed++;
        }
    }

    console.log('\n------------------------');
    console.log(`Gelukt: ${success}`);
    console.log(`Mislukt: ${failed}`);
    console.log(`Output: ${outputDir}`);

    if (failed > 0) {
        process.exitCode = 1;
    }
}

main().catch(error => {
    console.error('Export mislukt:', error.message);
    process.exitCode = 1;
});
