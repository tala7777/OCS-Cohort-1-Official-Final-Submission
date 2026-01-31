<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([


            [
                'name' => 'Ahmad',
                'email' => 'ahmad@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780632320',
                'role' => 'admin',
                'created_at' => '2026-01-21 17:23:28'
            ],
            [
                'name' => 'Mohammad',
                'email' => 'moh@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780675820',
                'role' => 'admin',
                'created_at' => '2026-01-21 17:23:28'
            ],
            [
                'name' => 'Qasem',
                'email' => 'qasem@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780952320',
                'role' => 'admin',
                'created_at' => '2026-01-21 17:23:28'
            ],
            [
                'name' => 'Adnan',
                'email' => 'adnan@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780952320',
                'role' => 'owner',
                'created_at' => '2026-01-21 17:27:28'
            ],
            [
                'name' => 'Omar',
                'email' => 'omar@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780952320',
                'role' => 'owner',
                'created_at' => '2026-01-25 17:27:28'
            ],
            [
                'name' => 'Saleh',
                'email' => 'saleh@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0788752320',
                'role' => 'owner',
                'created_at' => '2026-01-23 17:27:28'
            ],
            [
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780952320',
                'role' => 'student',
                'created_at' => '2026-01-21 17:35:28'
            ],
            [
                'name' => 'Mohammad',
                'email' => 'mohamma123@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780562320',
                'role' => 'student',
                'created_at' => '2026-01-24 17:35:28'
            ],
            [
                'name' => 'Mosaab',
                'email' => 'mosaab@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780924820',
                'role' => 'student',
                'created_at' => '2026-01-22 17:35:28'
            ],
            [
                'name' => 'Rida',
                'email' => 'rida@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '078572320',
                'role' => 'student',
                'created_at' => '2026-01-23 17:35:28'
            ],
            [
                'name' => 'Abdulla',
                'email' => 'abdulla123@gmail.com',
                'password' => '$2y$12$qA81UYAWqqWhFRfULVn.GeRGGZXQHrfwH02/ul9ir82aFlN4clnIS',
                'phone' => '0780579320',
                'role' => 'student',
                'created_at' => '2026-01-19 17:35:28'
            ],



        ]);

    }
}
