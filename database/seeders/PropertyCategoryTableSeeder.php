<?php

namespace Database\Seeders;

use App\Models\PropertyCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PropertyCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cafes & Restaurants',
                'description' => 'Dining and food service establishments',
                'service_fee' => 500.0,
                'is_government' => 0,
            ],
            [
                'name' => 'Large-Sized Business',
                'description' => 'Large-sized business establishments',
                'service_fee' => 1000.0,
                'is_government' => 0,
            ],
            [
                'name' => 'Medium-Sized Business',
                'description' => 'Medium-sized business establishments',
                'service_fee' => 500.0,
                'is_government' => 0,
            ],
            [
                'name' => 'Small-Sized Business',
                'description' => 'Small-sized business establishments',
                'service_fee' => 150.0,
                'is_government' => 0,
            ],
            [
                'name' => 'State-Owned Enterprises (SOE)',
                'description' => 'State-owned enterprises and public corporations',
                'service_fee' => 1000.0,
                'is_government' => 1,
            ],
            [
                'name' => 'Schools & Hospitals',
                'description' => 'Educational and healthcare institutions',
                'service_fee' => 1000.0,
                'is_government' => 1,
            ],
            [
                'name' => 'Government Offices',
                'description' => 'Government offices and public establishments',
                'service_fee' => 500.0,
                'is_government' => 1,
            ],
            [
                'name' => 'Residential - Unoccupied',
                'description' => 'Houses where people do not live',
                'service_fee' => 75.0,
                'is_government' => 0,
            ],
            [
                'name' => 'Residential - Occupied',
                'description' => 'Households where people live',
                'service_fee' => 100.0,
                'is_government' => 0,
            ],
        ];


        foreach ($categories as $category) {
            PropertyCategory::create($category);
        }
    }
}
