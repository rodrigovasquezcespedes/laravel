<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'store_id' => 1,
                'name' => 'Premium SaaS Subscription',
                'description' => 'Access to all premium features including advanced analytics, unlimited users, and priority support.',
                'price' => 49.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Unlimited users',
                    'Advanced analytics',
                    'Priority support',
                    'Custom branding',
                    'API access',
                ]),
                'is_active' => true,
            ],
            [
                'store_id' => 1,
                'name' => 'Starter Plan',
                'description' => 'Perfect for small teams and startups. Includes basic features to get you started.',
                'price' => 19.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Up to 10 users',
                    'Basic analytics',
                    'Email support',
                    'Standard features',
                ]),
                'is_active' => true,
            ],
            [
                'store_id' => 1,
                'name' => 'Enterprise Solution',
                'description' => 'Complete solution for large organizations with dedicated support and custom features.',
                'price' => 199.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Unlimited everything',
                    'Dedicated account manager',
                    '24/7 phone support',
                    'Custom integrations',
                    'SLA guarantee',
                    'On-premise deployment',
                ]),
                'is_active' => true,
            ],
            [
                'store_id' => 1,
                'name' => 'Annual Premium',
                'description' => 'Save 25% by paying annually for our premium plan.',
                'price' => 449.99,
                'billing_cycle' => 'yearly',
                'features' => json_encode([
                    'Unlimited users',
                    'Advanced analytics',
                    'Priority support',
                    'Custom branding',
                    'API access',
                    '3 months free',
                ]),
                'is_active' => true,
            ],
            [
                'store_id' => 2,
                'name' => 'Test Product',
                'description' => 'A test product for development purposes.',
                'price' => 9.99,
                'billing_cycle' => 'monthly',
                'features' => json_encode([
                    'Test feature 1',
                    'Test feature 2',
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
