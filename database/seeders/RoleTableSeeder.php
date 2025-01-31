<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'User',
                'description' => 'User Role description'
            ],
            [
                'name' => 'Officer',
                'description' => 'Officer Role description'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
