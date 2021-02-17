<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EpicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('epics')->insert([
            [
                'project_id' => 1,
                'description' => 'Buy a plane ticket',
                'user_id_editing' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'project_id' => 1,
                'description' => 'Post-sale',
                'user_id_editing' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
