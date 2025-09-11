<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',

            'view jobs',
            'create jobs',
            'edit jobs',
            'delete jobs',

            'jobs publish',
            'jobs options',

            'view applicants',
            'edit applicants',
            'delete applicants',
            'create applicants',

            'view resindo applicants',
            'edit resindo applicants',
            'delete resindo applicants',
            'create resindo applicants',

            'pipeline action',
            'pipeline move stage',
            'pipeline move recomend',

            'pipeline resindo action',
            'pipeline resindo move stage',
            'pipeline resindo move recomend',

            'sidemenu jobs',
            'sidemenu pipeline isolutions',
            'sidemenu pipeline resindo',
            'sidemenu user management',
            'sidemenu setting'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
