<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'telephone' => ['required', 'string', 'max:25', 'regex:/^\+?[0-9][0-9 ()-]{5,23}[0-9]$/'],
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(fn () => User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'telephone' => $input['telephone'],
            'password' => $input['password'],
            'role_id' => Role::firstOrCreate(['name' => Role::DEFAULT_NAME])->id,
        ]));
    }
}
