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
        $users = User::inRandomOrder()->limit(3)->get()->pluck('id')->toArray();
        $faker = Faker::create();
        $manager = User::inRandomOrder()->first();
        for ($i = 0; $i < 6; $i++) {
            $organisation = Organisation::create([
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
            $organisation->users()->attach($users);
        }
    }
}
