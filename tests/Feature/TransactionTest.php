<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionTest extends TestCase
{
    /**
     * Test index all transaction.
     *
     * @return void
     */
    public function test_transaction_get_all_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withHeaders(['X-touchpoint-request' => 'testing',])
            ->get('/transactions');

        $response->assertStatus(200);
        $response->assertViewIs('pages.transactions.index');
        $response->assertViewHas(
            'data',
            Transaction::orderBy('id', 'desc')
                ->get()
        );
    }
}
