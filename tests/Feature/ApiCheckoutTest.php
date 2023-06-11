<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiCheckoutTest extends TestCase
{
    use WithFaker;

    /**
     * The Checkout data test.
     *
     * @var array
     */
    protected $data;

    /**
     * Prepare checkout data test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'name' => 'Uni test',
            'email' => 'unitest@example.com',
            'number' => '19922',
            'address' => '9987 Test',
            'transaction_total' => 404,
            'transaction_status' => 'PENDING',
            'transaction_detail' => []
        ];
    }

    /**
     * Test checkout.
     */
    public function test_checkout_success(): void
    {
        DB::transaction(function () {
            $user = User::factory()->create();

            $product = Product::create([
                'name' => $this->faker->word,
                'type' => $this->faker->randomElement(['Atasan', 'Bawahan', 'Jaket', 'Sepatu']),
                'description' => $this->faker->sentence,
                'price' => $this->faker->numberBetween(250000, 2250000),
                'quantity' => $this->faker->numberBetween(300, 1000),
            ]);
            $this->data['transaction_detail'][] = $product->slug;

            $response = $this->actingAs($user)
                ->withHeaders([
                    'X-touchpoint-request' => 'testing',
                ])
                ->post('/api/checkouts', $this->data);

            $response->assertStatus(201);

            $response->assertJsonStructure([
                'meta',
                'data',
            ]);

            $response->assertJson([
                'meta' => [
                    'message' => "Transaksi Berhasil!",
                    'status_code' => 201,
                    'status' => 'success',
                ],
            ]);

            $this->assertDatabaseHas('transactions', [
                'name' => $this->data['name'],
                'email' => $this->data['email'],
                'number' => $this->data['number'],
                'address' => $this->data['address'],
                'transaction_total' => $this->data['transaction_total'],
                'transaction_status' => $this->data['transaction_status'],
                'uuid' => $response['data']['uuid'],
            ]);

            $this->assertDatabaseHas('transaction_details', [
                'transactions_id' => $response['data']['id'],
                'products_id' => $product->id,
            ]);
        });
    }
}
