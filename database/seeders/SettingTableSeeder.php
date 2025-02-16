<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'fine_amount',
                'value' => 10.0
            ],
            [
                'key' => 'validity_period',
                'value' => 40
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
