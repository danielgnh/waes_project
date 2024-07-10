<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {
        $projects = ['Web Development', 'Mobile App', 'Data Analysis', 'Machine Learning Project', 'Cloud Migration'];
        $descriptions = [
            'A comprehensive project focused on web development using modern technologies.',
            'Development of a cross-platform mobile application.',
            'Analysis of large datasets to extract meaningful insights.',
            'Implementing machine learning algorithms to solve real-world problems.',
            'Migrating existing infrastructure to the cloud for scalability and efficiency.'
        ];
        $users = User::inRandomOrder()->limit(3)->get()->pluck('id')->toArray();

        $faker = Faker::create();
        $manager = User::inRandomOrder()->first();
        for ($i = 0; $i < 5; $i++) {
            Project::create([
                'name' => $faker->randomElement($projects),
                'description' => $faker->randomElement($descriptions),
                'status' => 'active',
                'start_date' => $faker->dateTimeThisYear(),
                'end_date' => $faker->dateTimeThisYear,
                'project_manager' => $manager->id,
                'people' => $users
            ]);
        }
    }
}
