<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions « métier » du TP
        $perms = [
            'planets.manage',
            'crew.manage',
            'technologies.manage',
        ];

        foreach ($perms as $name) {
            Permission::findOrCreate($name, 'web');
        }

        // Rôles
        $admin  = Role::findOrCreate('Administrateur', 'web');
        $gPlan  = Role::findOrCreate('Gestionnaire Planètes', 'web');
        $gCrew  = Role::findOrCreate('Gestionnaire Équipage', 'web');
        $gTech  = Role::findOrCreate('Gestionnaire Technologies', 'web');

        // Attribution des permissions
        $gPlan->syncPermissions(['planets.manage']);
        $gCrew->syncPermissions(['crew.manage']);
        $gTech->syncPermissions(['technologies.manage']);

        // L’Administrateur a tout
        $admin->syncPermissions($perms);
    }
}
