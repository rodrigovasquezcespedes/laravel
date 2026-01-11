<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed stores first as other models depend on it
        $this->call([
            \Database\Seeders\StoreSeeder::class,
            \Database\Seeders\RoleSeeder::class,
            \Database\Seeders\SubscriptionPlanSeeder::class,
            \Database\Seeders\ProductSeeder::class,
        ]);

        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'store_id' => 1,
        ]);

        // Assign admin role
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminUser->roles()->attach($adminRole->id);
        }

        // Create regular test user
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'store_id' => 1,
        ]);

        // Assign user role
        $userRole = \App\Models\Role::where('name', 'user')->first();
        if ($userRole) {
            $testUser->roles()->attach($userRole->id);
        }
    }
}
