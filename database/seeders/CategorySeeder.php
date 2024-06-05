<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Meals & Foodstuffs',
                'keyword' => 'meals, food, groceries, snacks',
                'slug' => 'food',
            ],
            [
                'name' => 'Cleaning Supplies',
                'keyword' => 'cleaning, supplies, detergent, soap, disinfectant',
                'slug' => 'cleaning',
            ],
            [
                'name' => 'Personal Care',
                'keyword' => 'personal care, toiletries, hygiene, shampoo, toothpaste',
                'slug' => 'personal-care',
            ],
            [
                'name' => 'School Supplies',
                'keyword' => 'school supplies, notebooks, pens, pencils, textbooks',
                'slug' => 'school-supplies',
            ],
            [
                'name' => 'Laundry Essentials',
                'keyword' => 'laundry, essentials, detergent, fabric softener, clothespins',
                'slug' => 'laundry',
            ],
            [
                'name' => 'Health & Wellness',
                'keyword' => 'health, wellness, vitamins, medicine, first aid',
                'slug' => 'health-wellness',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'id' => Str::uuid(),
                'name' => $category['name'],
                'keyword' => $category['keyword'],
                'slug' => $category['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
