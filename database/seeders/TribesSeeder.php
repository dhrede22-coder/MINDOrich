<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TribesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tribes')->insert([

            [
                'tribe_name' => 'Iraya',
                'cover_image' => null,
                'description' => 'Known for basket weaving and traditional craftsmanship.',
                'history' => null,
                'location' => 'Northern Mindoro',
                'language' => 'Iraya',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tribe_name' => 'Alangan',
                'cover_image' => null,
                'description' => 'Known for their oral traditions.',
                'history' => null,
                'location' => 'Central Mindoro',
                'language' => 'Alangan',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tribe_name' => 'Tadyawan',
                'cover_image' => null,
                'description' => 'Preserves farming traditions.',
                'history' => null,
                'location' => 'Oriental Mindoro',
                'language' => 'Tadyawan',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tribe_name' => 'Tau-buid',
                'cover_image' => null,
                'description' => 'Deep connection with the forests.',
                'history' => null,
                'location' => 'Central Mindoro',
                'language' => 'Tau-buid',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tribe_name' => 'Hanunuo',
                'cover_image' => null,
                'description' => 'Known for the Hanunuo script.',
                'history' => null,
                'location' => 'Southern Mindoro',
                'language' => 'Hanunuo',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tribe_name' => 'Buhid',
                'cover_image' => null,
                'description' => 'Maintains indigenous writing.',
                'history' => null,
                'location' => 'Southern Mindoro',
                'language' => 'Buhid',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tribe_name' => 'Ratagnon',
                'cover_image' => null,
                'description' => 'One of the smallest Mangyan tribes.',
                'history' => null,
                'location' => 'Southern Mindoro',
                'language' => 'Ratagnon',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'tribe_name' => 'Bangon',
                'cover_image' => null,
                'description' => 'A culturally rich Mangyan community.',
                'history' => null,
                'location' => 'Central Mindoro',
                'language' => 'Bangon',
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}