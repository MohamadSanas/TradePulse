<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TradeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_selling_full_remaining_balance_does_not_divide_by_zero(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('trades.store'), [
                'type' => 'buy',
                'amount_usdt' => 100,
                'bank_fee' => 0,
                'total_lkr' => 30000,
                'fee' => 0,
            ])
            ->assertRedirect('/trades');

        $this->actingAs($user)
            ->post(route('trades.store'), [
                'type' => 'sell',
                'amount_usdt' => 100,
                'bank_fee' => 0,
                'total_lkr' => 32000,
                'fee' => 0,
            ])
            ->assertRedirect('/trades');

        $this->assertDatabaseHas('effective_buy_prices', [
            'user_id' => $user->id,
            'remaining_usdt' => 0,
            'remaining_lkr' => 0,
            'Breakeven_Price' => 0,
        ]);
    }
}
