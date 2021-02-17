<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_stories')->insert([

            //User stories for epic id 1
            [
                'epic_id' => 1,
                'user_id' => 1,
                'description' => 'Flight search',
                'priority' => 1,
                'value' => 1,
                'risk' => 1,
                'estimate' => 'S',
                'acceptance' => null,
                'notes' => null,
                'category' => 'Strategic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'epic_id' => 1,
                'user_id' => 1,
                'description' => 'Search by date',
                'priority' => 1,
                'value' => 2,
                'risk' => 1,
                'estimate' => 'XS',
                'acceptance' => null,
                'notes' => null,
                'category' => 'Strategic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'epic_id' => 1,
                'user_id' => 1,
                'description' => 'Search by price',
                'priority' => 2,
                'value' => 2,
                'risk' => 2,
                'estimate' => 'XS',
                'acceptance' => null,
                'notes' => null,
                'category' => 'Strategic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'epic_id' => 1,
                'user_id' => 1,
                'description' => 'Pay by credit card',
                'priority' => 1,
                'value' => 1,
                'risk' => 1,
                'estimate' => 'M',
                'acceptance' => null,
                'notes' => 'Accept Visa',
                'category' => 'Strategic',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);


        DB::table('user_stories')->insert([

            //User stories for epic id 2
            [
                'epic_id' => 2,
                'user_id' => 2,
                'description' => 'Refunds',
                'priority' => 2,
                'value' => 1,
                'risk' => 3,
                'estimate' => 'M',
                'acceptance' => null,
                'notes' => null,
                'category' => 'Leveraged',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'epic_id' => 2,
                'user_id' => 2,
                'description' => 'Same day exchange',
                'priority' => 1,
                'value' => 4,
                'risk' => 2,
                'estimate' => 'XXS',
                'acceptance' => null,
                'notes' => null,
                'category' => 'Focused',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
