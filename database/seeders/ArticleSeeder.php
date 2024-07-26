<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
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
        for ($i = 0; $i < 30; $i++) {
            DB::table('articles')->insert([
                'name' => $this->faker->name,
                'slug' => $this->faker->slug,
                'display_order' => $this->faker->numberBetween(1, 10),
                'description' => $this->faker->text(200),
                'min_read' => $this->faker->numberBetween(10, 20),
                'image' => $this->faker->imageUrl(),
                'about' => $this->faker->text(20),
                'views' => $this->faker->numberBetween(0, 100),
                'status' => $this->faker->boolean,
                'created_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
                'updated_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            ]);
        }
    }
}
