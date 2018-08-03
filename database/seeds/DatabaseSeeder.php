<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 1000;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('news')->insert([
                'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'message' => $faker->text($maxNbChars = 200),
                'public_flag' => rand(0,1),
                'created_at' => $faker->date($format = 'Y-m-d', $max = 'now'),
            ]);
        }
    }
}
