<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'permission-create',
            'display_name' => 'Create a new Permission',
            'description' => 'This permission allow the user to create a new permission',
        ]);
        Permission::create([
            'name' => 'permission-read',
            'display_name' => 'View or Read the Permission',
            'description' => 'This permission allow the user to view the info of permission',
        ]);
        Permission::create([
            'name' => 'permission-update',
            'display_name' => 'Update the Permission',
            'description' => 'This permission allow the user to update the permission',
        ]);
        Permission::create([
            'name' => 'permission-delete',
            'display_name' => 'Delete the Permission',
            'description' => 'This permission allow the user to delete available permission',
        ]);
    }
}
