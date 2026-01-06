<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Subscription;

class SubscriptionFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_subscribe_and_cancel()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 10]);
        $this->actingAs($user, 'api');

        // Simular pago
        $response = $this->postJson('/api/pay', [
            'product_id' => $product->id
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => 'active',
        ]);

        $subscription = Subscription::where('user_id', $user->id)->first();
        // Cancelar
        $cancel = $this->postJson('/api/subscriptions/' . $subscription->id . '/cancel');
        $cancel->assertStatus(200);
        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'cancelled',
        ]);
    }
}
