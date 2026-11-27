# User Stories

Onder iedere user story staan de acceptatiecriteria. Een user story is pas af als aan alle criteria is voldaan.
Rollen in de applicatie: Admin, Finance, Sales, Inkoop, Maintenance en Planner.

## Login & users

**US01 — Inloggen**  
Als gebruiker wil ik kunnen inloggen zodat ik toegang krijg tot de applicatie.

Acceptatiecriteria:
- Een gebruiker kan inloggen met e-mailadres en wachtwoord.
- Bij een fout e-mailadres of wachtwoord verschijnt een foutmelding en blijft de gebruiker op het inlogscherm.
- Een gebruiker die niet is ingelogd en een pagina opent, wordt doorgestuurd naar het inlogscherm.
- Een ingelogde gebruiker kan uitloggen en komt daarna terug op het inlogscherm.
- Wachtwoorden worden niet leesbaar (gehasht) opgeslagen in de database.

**US02 — Rollen**  
Als beheerder wil ik gebruikers verschillende rollen kunnen geven zodat iedereen de juiste rechten heeft.

Acceptatiecriteria:
- Iedere gebruiker heeft precies één rol: Admin, Finance, Sales, Inkoop, Maintenance of Planner.
- Alleen de Admin kan gebruikersaccounts aanmaken en een rol toewijzen.
- De Admin heeft geen toegang tot de pagina's van de afdelingen (alleen gebruikersbeheer).
- Een gebruiker die een pagina van een andere rol opent, krijgt een "geen toegang"-melding (403).
- De rechten worden op de server gecontroleerd, niet alleen door knoppen te verbergen.

**US03 — Dashboard**  
Als gebruiker wil ik na het inloggen een dashboard zien dat bij mijn rol past.

Acceptatiecriteria:
- Na het inloggen komt de gebruiker direct op het dashboard van de eigen rol.
- Het menu toont alleen de onderdelen waar de rol toegang toe heeft.
- Het dashboard toont de belangrijkste informatie voor die rol (bijv. Maintenance: aantal open en urgente storingen).
- Het dashboard is bruikbaar op desktop, tablet en mobiel.

## Storingen

**US04 — Storingen bekijken**  
Als Maintenance-medewerker wil ik binnengekomen storingen kunnen bekijken zodat ik weet wat er opgelost moet worden.

Acceptatiecriteria:
- Maintenance ziet een overzicht van alle storingsaanvragen met klant, machine, prioriteit, status en datum.
- Het overzicht kan gefilterd worden op status (open, in behandeling, opgelost) en prioriteit (laag, normaal, hoog, urgent).
- Urgente en open storingen zijn duidelijk herkenbaar en staan bovenaan.
- Bij het openen van een storing zijn de volledige probleemomschrijving en het adres van de klant zichtbaar.
- Rollen zonder rechten (bijv. Finance) kunnen het overzicht niet openen.
- De storingsaanvragen worden via een seeder in de database gezet.

**US05 — Storing aanmaken**  
Als Sales-medewerker wil ik een storing kunnen aanmaken zodat problemen van klanten geregistreerd worden.

Acceptatiecriteria:
- Sales kan een storing aanmaken met de velden klant, machine, omschrijving en prioriteit.
- Klant en omschrijving zijn verplicht; zonder deze velden wordt de storing niet opgeslagen en verschijnt een foutmelding per veld.
- Een nieuwe storing krijgt automatisch status "open" en wordt gekoppeld aan de Sales-medewerker die hem aanmaakt.
- Na het opslaan verschijnt een bevestiging en is de storing direct zichtbaar in het overzicht van Maintenance.
- Er kunnen alleen storingen worden aangemaakt voor bestaande klanten.

**US06 — Storing aanpassen**  
Als Sales-medewerker wil ik een storing kunnen aanpassen zodat fouten verbeterd kunnen worden.

Acceptatiecriteria:
- Sales kan klant, machine, omschrijving en prioriteit van een bestaande storing aanpassen.
- Bij het aanpassen gelden dezelfde verplichte velden en validatie als bij aanmaken.
- Na het opslaan zijn de wijzigingen direct zichtbaar voor Maintenance.
- Een storing met status "opgelost" kan niet meer door Sales worden aangepast.
- Andere rollen dan Sales kunnen het bewerkformulier niet openen.

## Klanten

**US07 — Klant aanmaken**  
Als Sales-medewerker wil ik een klant kunnen toevoegen zodat deze centraal opgeslagen wordt.

Acceptatiecriteria:
- Sales kan een klant aanmaken met bedrijfsnaam, contactpersoon, e-mail, telefoon, adres, postcode en plaats.
- Bedrijfsnaam is verplicht; e-mail moet een geldig e-mailadres zijn.
- Een nieuwe klant staat standaard op "BKR nog niet gecontroleerd".
- Na het opslaan staat de klant in het klantenoverzicht.

**US08 — Klantgegevens bekijken**  
Als Sales-medewerker wil ik klantgegevens kunnen bekijken zodat ik snel de juiste informatie heb.

Acceptatiecriteria:
- Sales kan in het klantenoverzicht zoeken op bedrijfsnaam, contactpersoon en plaats.
- De detailpagina van een klant toont contactgegevens, adres, offertes, leasecontracten, factuurstatus en storingen.
- De detailpagina is goed bruikbaar op een tablet en mobiel.

**US09 — Notities en afspraken**  
Als Sales-medewerker wil ik notities en afspraken bij een klant kunnen opslaan zodat informatie niet verloren gaat.

Acceptatiecriteria:
- Sales kan bij een klant een notitie of afspraak toevoegen.
- Een afspraak heeft een datum en tijd; een notitie alleen tekst.
- Bij iedere notitie wordt opgeslagen wie hem heeft geschreven en wanneer.
- Notities en afspraken staan op de klantpagina, nieuwste bovenaan.
- Een lege notitie kan niet worden opgeslagen.

## Offertes

**US10 — Producten bekijken**  
Als Sales-medewerker wil ik producten kunnen bekijken zodat ik een geschikt product voor een klant kan kiezen.

Acceptatiecriteria:
- Sales ziet een productoverzicht ingedeeld per categorie (bijv. koffiemachines, koffiebonen).
- Per product zijn naam, korte omschrijving en prijs zichtbaar.
- Producten die alleen voor medewerkers bedoeld zijn (bijv. onderdelen) worden niet getoond.
- Het overzicht is bruikbaar op een 8-inch tablet.

**US11 — Offerte maken**  
Als Sales-medewerker wil ik een offerte kunnen maken zodat ik een voorstel naar een klant kan sturen.

Acceptatiecriteria:
- Sales kan een offerte maken voor een bestaande klant met één of meer producten en aantallen.
- Bij de offerte kan worden aangegeven of de klant een onderhoudscontract wil.
- Het totaalbedrag wordt automatisch berekend uit de productregels.
- Een offerte krijgt een uniek offertenummer en de status "concept".
- Koffiemachines worden alleen als lease aangeboden, niet als verkoop.
- Het offertescherm is bruikbaar op een 8-inch tablet.

**US12 — Offerte versturen**  
Als Sales-medewerker wil ik een offerte per mail kunnen versturen zodat de klant deze ontvangt.

Acceptatiecriteria:
- Sales kan een offerte per e-mail versturen naar het e-mailadres van de klant.
- De offerte zit als nette bijlage (PDF) bij de e-mail, in de huisstijl van Barroc Intens.
- Na het versturen krijgt de offerte de status "verstuurd" en wordt de verzenddatum opgeslagen.
- Heeft de klant geen e-mailadres, dan verschijnt een foutmelding en wordt er niets verstuurd.

## Finance

**US13 — Leasecontract beheren**  
Als financieel medewerker wil ik leasecontracten kunnen aanmaken, aanpassen en verwijderen.

Acceptatiecriteria:
- Finance kan een leasecontract aanmaken voor een klant met startdatum, einddatum en regels (apparaat en bonen).
- Een leasecontract kan alleen worden aangemaakt als de BKR-check van de klant is afgevinkt en de klant geen BKR-registratie heeft.
- Het maandbedrag wordt berekend uit de regels van het contract.
- Finance kan een contract aanpassen en verwijderen; bij verwijderen wordt eerst om bevestiging gevraagd.
- Einddatum mag niet vóór de startdatum liggen.

**US14 — Leasecontracten bekijken**  
Als financieel medewerker wil ik leasecontracten kunnen bekijken zodat ik overzicht heb van de afspraken.

Acceptatiecriteria:
- Finance ziet een overzicht van alle leasecontracten met klant, looptijd, maandbedrag en status.
- Het overzicht kan gefilterd worden op status (actief, beëindigd).
- Bij het openen van een contract zijn alle regels (apparaten en bonen) zichtbaar.

**US15 — Facturen beheren**  
Als financieel medewerker wil ik facturen kunnen aanmaken en bijhouden zodat de administratie klopt.

Acceptatiecriteria:
- Finance kan een factuur aanmaken voor een klant, met factuurdatum, vervaldatum en factuurregels.
- Iedere factuur krijgt een uniek factuurnummer.
- Finance kan een factuur op "betaald" zetten; de betaaldatum wordt dan opgeslagen.
- Facturen waarvan de vervaldatum verstreken is en die niet betaald zijn, krijgen de status "achterstallig".
- Bij een achterstallige factuur kan het systeem een eerste en een tweede betalingsherinnering versturen; meer dan twee kan niet.

**US16 — BKR-check**  
Als financieel medewerker wil ik kunnen aangeven of een klant een BKR-registratie heeft zodat financiële risico's zichtbaar zijn.

Acceptatiecriteria:
- Finance kan bij een klant afvinken dat de BKR-check is uitgevoerd (de check zelf gebeurt buiten de applicatie).
- Finance kan aangeven of de klant een BKR-registratie heeft.
- Bij een klant met BKR-registratie is een duidelijke waarschuwing zichtbaar.
- Er wordt opgeslagen wie de check heeft afgevinkt en wanneer.
- Alleen Finance kan de BKR-gegevens aanpassen.

## Inkoop & voorraad

**US17 — Producten beheren**  
Als inkoopmedewerker wil ik producten kunnen toevoegen, aanpassen en verwijderen.

Acceptatiecriteria:
- Inkoop kan een product aanmaken met naam, merk, categorie, omschrijving, prijs en productcode.
- Naam, categorie en prijs zijn verplicht; prijs moet een positief getal zijn.
- Per product kan worden ingesteld of het zichtbaar is voor klanten of alleen voor medewerkers.
- Bij verwijderen wordt eerst om bevestiging gevraagd; oude offertes en werkbonnen met dit product blijven kloppen.

**US18 — Voorraad beheren**  
Als inkoopmedewerker wil ik de voorraad kunnen bijhouden zodat we weten wat er beschikbaar is.

Acceptatiecriteria:
- Per product zijn de huidige voorraad en de minimale voorraad zichtbaar.
- Producten onder de minimale voorraad worden duidelijk gemarkeerd.
- Inkoop kan een bestelling plaatsen om bij te bestellen.
- Bij het ontvangen van een bestelling wordt de voorraad automatisch verhoogd.
- De voorraad kan niet onder 0 komen.

**US19 — Grote inkopen goedkeuren**  
Als leidinggevende wil ik grote inkopen kunnen goedkeuren voordat ze besteld worden.

Acceptatiecriteria:
- Een bestelling van meer dan 5000 producten krijgt automatisch de status "wacht op goedkeuring".
- Zo'n bestelling kan pas worden geplaatst nadat een leidinggevende hem heeft goedgekeurd.
- De leidinggevende kan de bestelling goedkeuren of afkeuren; dit wordt met naam en datum opgeslagen.
- Bestellingen van 5000 producten of minder hebben geen goedkeuring nodig.

**US20 — Voorraad zoeken**  
Als inkoopmedewerker wil ik op producten kunnen zoeken en filteren zodat ik snel kan vinden wat ik nodig heb.

Acceptatiecriteria:
- Inkoop kan zoeken op merk en omschrijving.
- Inkoop kan filteren op voorraadstatus (op voorraad, onder minimum, niet op voorraad).
- Zoeken en filteren kunnen samen gebruikt worden.
- Bij geen resultaten verschijnt de melding "Geen producten gevonden".

## Planning

**US21 — Bezoek inplannen**  
Als planner wil ik bezoeken kunnen inplannen zodat monteurs weten wanneer ze naar een klant moeten.

Acceptatiecriteria:
- De planner kan een bezoek inplannen met datum, begintijd, eindtijd en machine.
- Een bezoek is een storingsbezoek (gekoppeld aan een storingsaanvraag) of een routinematig onderhoudsbezoek.
- Een bezoek kan niet in het verleden worden ingepland.
- Een ingeplande storing krijgt de status "in behandeling".
- Er kunnen geen bezoeken worden ingepland bij klanten die geen klant meer zijn.

**US22 — Monteur koppelen**  
Als planner wil ik een monteur aan een bezoek kunnen koppelen.

Acceptatiecriteria:
- De planner kan één monteur (Maintenance-medewerker) kiezen bij een bezoek.
- Alleen gebruikers met de rol Maintenance kunnen gekozen worden.
- Heeft de monteur op dat tijdstip al een bezoek, dan verschijnt een waarschuwing.
- Het bezoek verschijnt direct in de kalender van de gekoppelde monteur.

**US23 — Kalender bekijken**  
Als monteur wil ik mijn planning per dag en week kunnen bekijken.

Acceptatiecriteria:
- De monteur ziet een kalender met alleen zijn eigen bezoeken.
- Er kan gewisseld worden tussen dag- en weekoverzicht en naar de vorige/volgende dag of week.
- Per bezoek zijn tijd, klant en type (storing of routine) zichtbaar.
- De kalender is goed bruikbaar op een tablet.

**US24 — Bezoekdetails bekijken**  
Als monteur wil ik de details van een bezoek kunnen bekijken zodat ik voorbereid naar de klant ga.

Acceptatiecriteria:
- Door op een bezoek te klikken opent een detailscherm.
- Het detailscherm toont klant, adres, contactpersoon, machine, locatie van de machine en tijdstip.
- Bij een storingsbezoek is de volledige probleemomschrijving zichtbaar, zodat de juiste materialen meegenomen kunnen worden.

## Werkbonnen

**US25 — Werkbon invullen**  
Als monteur wil ik na een bezoek een werkbon kunnen invullen zodat de werkzaamheden geregistreerd zijn.

Acceptatiecriteria:
- De monteur kan bij een bezoek een werkbon invullen met uitgevoerde werkzaamheden en bestede tijd.
- De klant kan digitaal tekenen ter bevestiging; zonder handtekening kan de werkbon niet worden afgerond.
- Na het afronden wordt de werkbon opgeslagen en per e-mail naar het hoofd Maintenance gestuurd.
- Een afgeronde werkbon krijgt de status "afgerond" en kan niet meer worden aangepast.
- Is de werkbon voor een storing, dan krijgt die storing de status "opgelost".

**US26 — Materialen registreren**  
Als monteur wil ik gebruikte materialen kunnen registreren zodat het voorraadverbruik bijgehouden wordt.

Acceptatiecriteria:
- De monteur kan op de werkbon gebruikte materialen aanvinken uit de productlijst.
- Per materiaal wordt de hoeveelheid ingevuld; deze moet minimaal 1 zijn.
- Na het afronden van de werkbon wordt de voorraad van die materialen verlaagd.

**US27 — Materiaalgebruik melden**  
Als inkoopmedewerker wil ik kunnen zien wanneer materiaal gebruikt is zodat ik de voorraad kan aanvullen.

Acceptatiecriteria:
- Inkoop krijgt een melding zodra een werkbon met gebruikte materialen is afgerond.
- De melding toont welk materiaal, hoeveel, bij welke werkbon en wanneer.
- Inkoop kan een melding als gezien markeren.
- Komt een product door het verbruik onder de minimale voorraad, dan is dat in de melding zichtbaar.

## Algemene informatie

**US28 — Centrale klantgegevens**  
Als medewerker wil ik klantgegevens centraal kunnen bekijken zodat iedereen met dezelfde informatie werkt.

Acceptatiecriteria:
- Klantgegevens worden op één plek in de database opgeslagen en door alle afdelingen gebruikt.
- Iedere rol ziet alleen de klantgegevens die hij nodig heeft (bijv. Maintenance geen financiële gegevens).
- Inactieve klanten (geen klant meer) zijn duidelijk als inactief gemarkeerd.

**US29 — Adres wijzigen**  
Als medewerker wil ik een klantadres centraal kunnen aanpassen zodat alle afdelingen het juiste adres gebruiken.

Acceptatiecriteria:
- Een bevoegde medewerker kan het adres van een klant aanpassen.
- Na het opslaan tonen alle schermen (storingen, planning, facturen) direct het nieuwe adres.
- Postcode moet een geldige Nederlandse postcode zijn (bijv. 1234 AB).

## Testen

**US30 — Technische tests**  
Als ontwikkelteam willen we de applicatie technisch testen zodat fouten gevonden worden.

Acceptatiecriteria:
- Er zijn geautomatiseerde tests voor inloggen, rollen/rechten en de gebouwde onderdelen.
- De tests testen minimale, maximale en normale waarden van de invoervelden.
- Alle tests slagen voordat code naar main gaat.
- Er is een korte instructie hoe de tests gestart worden (`php artisan test`).

**US31 — Acceptatietest**  
Als Product Owner wil ik de belangrijkste onderdelen kunnen testen zodat ik kan beoordelen of het MVP goed werkt.

Acceptatiecriteria:
- Er is een acceptatietest met per user story de stappen en het verwachte resultaat.
- Het team voert de acceptatietest eerst zelf uit en noteert de resultaten.
- De resultaten van de test met de Product Owner worden vastgelegd.

**US32 — Testdata**  
Als ontwikkelteam willen we genoeg testdata hebben zodat de applicatie goed gedemonstreerd kan worden.

Acceptatiecriteria:
- Met één commando (`php artisan migrate:fresh --seed`) wordt alle testdata aangemaakt.
- Er zijn 150 actieve klanten en 40 inactieve klanten, waarvan 10 met BKR-registratie.
- Er zijn 500 facturen, waarvan 120 met een betalingsachterstand.
- Er zijn 150 leasecontracten.
- Er zijn 75 werkbonnen, waarvan 35 routinebonnen en 40 storingsbonnen.
- Er is voor iedere rol een testaccount.

**US33 — Verbetervoorstel**  
Als ontwikkelteam willen we gevonden problemen en verbeteringen bijhouden zodat duidelijk is wat nog aangepast moet worden.

Acceptatiecriteria:
- Alle bevindingen uit de acceptatietest staan in het verbetervoorstel.
- Per punt staan een korte omschrijving, een geschat aantal uren en een prioriteit.
- Het totaal aantal benodigde uren staat onderaan.

## Oplevering

**US34 — Presentatie**  
Als ontwikkelteam willen we het MVP presenteren zodat de stakeholders kunnen zien wat we gemaakt hebben.

Acceptatiecriteria:
- Ieder groepslid presenteert een eigen onderdeel.
- De presentatie laat zien wat gepland was, wat gerealiseerd is en wat niet af is.
- De werking wordt gedemonstreerd zonder technische details.
- De feedback van de opdrachtgever wordt genoteerd.

**US35 — Reflectie**  
Als student wil ik terugkijken op het project zodat ik weet wat goed ging en wat beter kan.

Acceptatiecriteria:
- De reflectie bevat minstens vijf verbeterpunten voor het volgende project.
- De reflectie bevat minstens drie dingen die goed gingen en die ik hetzelfde wil aanpakken.

## Huisstijl

**US36 — Huisstijl**  
Als gebruiker wil ik een Barroc Intens-uitstraling zien zodat de applicatie bij het bedrijf past.

Acceptatiecriteria:
- De applicatie gebruikt het logo, de kleuren en het lettertype (Big Shoulders Display) uit het huisstijlhandboek.
- Alle schermen hebben dezelfde opmaak en navigatie.
- Teksten in de applicatie zijn in het Nederlands.

## Nog voor te leggen aan de Product Owner

Deze punten zijn in het interview nog niet besloten. De criteria hierboven gaan uit van een redelijke aanname en worden aangepast als de PO iets anders wil.

- Welke velden zijn verplicht op een storingsaanvraag, offerte, klantdossier en werkbon?
- Wat mag iedere rol bekijken, toevoegen en wijzigen? Wie is "leidinggevende" bij grote inkopen?
- Welke taken heeft de Planner precies, en wat mag het hoofd Maintenance meer dan een monteur?
- Hoeveel dagen na de vervaldatum worden de eerste en tweede betalingsherinnering verstuurd?
- Welke rapportages wil Finance precies zien (per maand / per jaar)?
- Hoe komen meldingen vanuit de externe klantenservice in het systeem?
