<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'description' => 'Perfect for individuals getting started',
                'price' => 9.99,
                'billing_interval' => 'monthly',
                'features' => json_encode([
                    '1 user',
                    'Basic support',
                    '10 GB storage',
                    'Core features',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Pro',
                'description' => 'Great for growing businesses',
                'price' => 29.99,
                'billing_interval' => 'monthly',
                'features' => json_encode([
                    'Up to 5 users',
                    'Priority support',
                    '100 GB storage',
                    'Advanced features',
                    'API access',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'For large organizations',
                'price' => 99.99,
                'billing_interval' => 'monthly',
                'features' => json_encode([
                    'Unlimited users',
                    '24/7 dedicated support',
                    'Unlimited storage',
                    'All features',
                    'API access',
                    'Custom integrations',
                    'SLA guarantee',
                ]),
                'is_active' => true,
            ],
            [
                'name' => 'Basic Annual',
                'description' => 'Save 20% with annual billing',
                'price' => 95.88,
                'billing_interval' => 'yearly',
                'features' => json_encode([
                    '1 user',
                    'Basic support',
                    '10 GB storage',
                    'Core features',
                    '2 months free',
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
