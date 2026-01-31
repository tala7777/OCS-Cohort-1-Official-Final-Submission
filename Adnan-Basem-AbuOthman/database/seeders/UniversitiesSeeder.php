<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {



        DB::table('universities')->insert([


            [
                'name' => 'University Of Jordan',
                'location' => 'Amman , Jordan',
                'image' => 'universities/u.jpg',

            ],
            [
                'name' => 'Hashemite University',
                'location' => 'Zarqa , Jordan',
                'image' => 'universities/h.jpg',

            ],
            [
                'name' => 'Al Al-bayet University',
                'location' => 'Mafraq , Jordan',
                'image' => 'universities/a.jpg',

            ],
            [
                'name' => 'Balqa University',
                'location' => 'Salt , Jordan',
                'image' => 'universities/b.jpg',

            ],
            [
                'name' => 'Mutah University',
                'location' => 'Karak , Jordan',
                'image' => 'universities/m.jpg',

            ],
            [
                'name' => 'Tafila Tecnical University',
                'location' => 'Tafila , Jordan',
                'image' => 'universities/t.jpg',

            ],
            [
                'name' => 'Jordan University of Science and Technology',
                'location' => 'Irbid , Jordan',
                'image' => 'universities/z.jpg',

            ],



        ]);





    }
}
