<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 2; $i++) {
            User::create([
                'name' => $faker->name,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->name,
                'salutation' => $faker->randomElement(['Mr', 'Ms', 'Mrs', 'Dr']),
                'phone' => $faker->phoneNumber,
                'password' => bcrypt('password'),
                'birthday' => $faker->dateTimeThisCentury(),
                'job_title' => $faker->jobTitle,
                'is_system_user' => 0,
                'is_customer' => 1,
            ]);
        }
    }
}
