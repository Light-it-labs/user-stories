<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(Project_User_RoleSeeder::class);
        $this->call(EpicSeeder::class);
        $this->call(UserStorySeeder::class);
    }
}
