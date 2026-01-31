<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::table('plans')->insert([

            [
                'name' => 'Starter',
                'price' => 5.00,
                'duration_days' => 10,
                'description' => 'Perfect for trying out the platform for a short period.',
                'max_apartments' => 3,
            ],
            [
                'name' => 'Professional',
                'price' => 20.00,
                'duration_days' => 30,
                'description' => 'Our most popular plan for serious property owners.',
                'max_apartments' => 15,
            ],
            [
                'name' => 'Enterprise',
                'price' => 50.00,
                'duration_days' => 365,
                'description' => 'Ultimate value with unlimited boundaries.',
                'max_apartments' => '9999',
            ]



        ]);




    }
}
