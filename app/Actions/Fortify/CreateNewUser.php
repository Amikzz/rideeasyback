<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

/**
 * Handles the creation of new user accounts.
 *
 * This class implements the `CreatesNewUsers` contract from Fortify and is
 * responsible for validating and creating a new user during the registration
 * process.
 */
class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * This method validates the user's input, including name, email, and password,
     * and then creates a new user record in the database.
     *
     * @param  array<string, string>  $input
     * @return \App\Models\User
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'conductor_admin_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'conductor_admin_id' => $input['conductor_admin_id'],
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

    }
}
