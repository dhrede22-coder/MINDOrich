<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([

            [
                'category_name' => 'Basketry',
                'description' => 'Handwoven baskets and storage items.',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_name' => 'Bags',
                'description' => 'Native bags and pouches.',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_name' => 'Accessories',
                'description' => 'Bracelets, necklaces, and accessories.',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_name' => 'Home Decor',
                'description' => 'Decorative handmade products.',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_name' => 'Clothing',
                'description' => 'Traditional garments and apparel.',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'category_name' => 'Jewelry',
                'description' => 'Traditional handmade jewelry.',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}