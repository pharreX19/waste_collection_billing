<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\SettingTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleTableSeeder::class,
            SettingTableSeeder::class
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        DB::statement('ALTER TABLE people MODIFY contact_no varchar(255) null;');
        DB::statement('ALTER TABLE people DROP INDEX people_national_id_unique;');

        $this->call([
            PropertyCategoryTableSeeder::class,
            // PropertyTableSeeder::class,
            // DhanaaluPropertyTableSeeder::class,
            // BusinessPropertyTableSeeder::class,
        ]);

        DB::statement('ALTER TABLE people MODIFY contact_no varchar(255);');
    }
}
