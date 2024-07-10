<?php

namespace Database\Seeders;

use App\Models\Organisation;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $manager = User::inRandomOrder()->first();
        for ($i = 0; $i < 20; $i++) {
            Organisation::create([
                'name' => $faker->company,
                'description' => $faker->companySuffix,
                'status' => 'active',
                'manager_id' => $manager->id,
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'zip_code' => $faker->postcode,
            ]);
        }
    }
}
