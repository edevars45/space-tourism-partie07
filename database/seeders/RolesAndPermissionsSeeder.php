<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Toujours vider le cache Spatie avant toute modif
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- 1) Permissions ---------------------------------------------------
        $perms = [
            'planets.manage',
            'crew.manage',
            'technologies.manage',
            'users.manage',
        ];

        foreach ($perms as $name) {
            Permission::firstOrCreate([
                'name'       => $name,
                'guard_name' => 'web',
            ]);
        }

        // --- 2) Rôles ---------------------------------------------------------
        $managerPlanets = Role::firstOrCreate(['name' => 'Gestionnaire Planètes', 'guard_name' => 'web']);
        $managerPlanets->givePermissionTo('planets.manage');

        $managerCrew = Role::firstOrCreate(['name' => 'Gestionnaire Équipage', 'guard_name' => 'web']);
        $managerCrew->givePermissionTo('crew.manage');

        $managerTech = Role::firstOrCreate(['name' => 'Gestionnaire Technologies', 'guard_name' => 'web']);
        $managerTech->givePermissionTo('technologies.manage');

        $admin = Role::firstOrCreate(['name' => 'Administrateur', 'guard_name' => 'web']);
        $admin->syncPermissions($perms);

        // --- 3) Donner le rôle Admin à TON compte ----------------------------
        // ⚠️ Remplace l'email ci-dessous par le tien
        $me = User::where('email', 'ton.email@exemple.com')->first();
        if ($me) {
            $me->assignRole('Administrateur');
            // Optionnel : marque l'email comme vérifié si tu veux éviter l'étape de vérif
            if (method_exists($me, 'markEmailAsVerified')) {
                $me->markEmailAsVerified();
            }
        }

        // Revider le cache Spatie après création
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
