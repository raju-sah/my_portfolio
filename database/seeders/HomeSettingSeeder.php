<?php

namespace Database\Seeders;

use App\Models\HomeSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeSetting::insert([
            [
                'id' => 1,
                'title' => 'title',
                'slug' => 'title',
               'logo' => 'logo.png',
               'image' => 'image.png',
               'description' => 'description',
               'status' => 1
            ],
        ]);
    }
}
