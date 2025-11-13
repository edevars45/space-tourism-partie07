<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Je crée (ou mets à jour) un compte admin de test et je lui donne le rôle Administrateur.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // J’utilise un email clair et un mot de passe connu pour le TP
        $email = 'admin@example.com';

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // à changer plus tard
                'email_verified_at' => now(),
            ]
        );

        // Je lui assigne le rôle Administrateur
        if (!$user->hasRole('Administrateur')) {
            $user->assignRole('Administrateur');
        }
    }
}
