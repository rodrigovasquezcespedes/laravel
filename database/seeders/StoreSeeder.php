<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::create([
            'name' => 'Demo Store',
            'slug' => 'demo',
            'domain' => 'demo.localhost',
            'configuration' => json_encode([
                'theme' => 'default',
                'currency' => 'USD',
            ]),
        ]);

        Store::create([
            'name' => 'Test Store',
            'slug' => 'test',
            'domain' => 'test.localhost',
            'configuration' => json_encode([
                'theme' => 'dark',
                'currency' => 'USD',
            ]),
        ]);
    }
}
