<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Permissions

        //Project Permissions
        Permission::create(['name' => 'create project']);
        Permission::create(['name' => 'edit project']);
        Permission::create(['name' => 'delete project']);

        //Epic Permissions
        Permission::create(['name' => 'create epic']);
        Permission::create(['name' => 'edit epic']);
        Permission::create(['name' => 'delete epic']);

        //UserStory Permissions
        Permission::create(['name' => 'create user story']);
        Permission::create(['name' => 'edit user story']);
        Permission::create(['name' => 'delete user story']);

        //Roles
        // create roles and assign created permissions

        $owner_role = Role::create(['name' => 'owner']);
        $owner_role->givePermissionTo(Permission::all());

        // this can be done as separate statements
        $role = Role::create(['name' => 'invited']);
        $role->givePermissionTo('create project');
        $role->givePermissionTo('edit project');
        $role->givePermissionTo('create epic');
        $role->givePermissionTo('edit epic');
        $role->givePermissionTo('create user story');
        $role->givePermissionTo('edit user story');

    }
}
