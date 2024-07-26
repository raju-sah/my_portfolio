<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     protected $faker;
     public function __construct()
     {
         $this->faker = Faker::create();
     }

    public function run(): void
    {

        for ($i = 0; $i < 50; $i++) {
            DB::table('reviews')->insert([
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'article_id' => Article::pluck('id')->random(),
                'rating' => $this->faker->numberBetween(1, 5),
                'status' => 1,
                'description' => $this->faker->text(100),
                'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
                'updated_at' => $this->faker->dateTimeBetween('-1 years', 'now'),

            ]);
        }
    }
}
