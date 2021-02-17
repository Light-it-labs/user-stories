<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class Project_User_RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_project_role')->insert([
            [
                'user_id' => 1,
                'project_id' => 1,
                'role_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'user_id' => 2,
                'project_id' => 1,
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'user_id' => 3,
                'project_id' => 1,
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'user_id' => 4,
                'project_id' => 1,
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
