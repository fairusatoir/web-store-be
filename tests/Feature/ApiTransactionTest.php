<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiTransactionTest extends TestCase
{

    use WithFaker;

    /**
     * Test get transactions.
     */
    public function test_transaction_get_all(): void
    {
        DB::transaction(function () {
            $user = User::factory()->create();
            $response = $this->actingAs($user)
                ->withHeaders([
                    'X-touchpoint-request' => 'testing',
                ])
                ->get('/api/transactions');

            $response->assertStatus(200);

            $response->assertJsonStructure([
                'data' => [
                    'data',
                    'total',
                    'links',
                ],
            ]);

            $response->assertJson([
                'meta' => [
                    'message' => 'Data Transaksi berhasil diambil!',
                    'status_code' => 200,
                    'status' => 'success',
                ],
            ]);
        });
    }

    /**
     * Test get product by id.
     *
     * @return void
     */
    public function test_product_get_by_trx()
    {
        DB::transaction(function () {
            $user = User::factory()->create();
            try {
                $transaction = Transaction::where('uuid', 'TRX202306109390')->get();
                throw_if($transaction, new ModelNotFoundException());
            } catch (ModelNotFoundException $e) {
                $transaction = Transaction::create([
                    'uuid' => "TRX" . date('Ymd') . $this->faker->randomNumber(4),
                    'name' => $this->faker->name,
                    'email' => $this->faker->email,
                    'number' => $this->faker->phoneNumber,
                    'address' => $this->faker->address,
                    'transaction_total' => $this->faker->numberBetween(2, 25),
                    'transaction_status' => $this->faker->randomElement(['PENDING', 'SUCCESS', 'FAILED']),
                ]);
            }
            $response = $this->actingAs($user)
                ->withHeaders([
                    'X-touchpoint-request' => 'testing',
                ])
                ->get("/api/transactions/{$transaction->uuid}");

            $response->assertStatus(200);

            $response->assertJsonStructure([
                'data',
                'meta'
            ]);

            $response->assertJson([
                'meta' => [
                    'message' => "Data Transaksi {$transaction->uuid} berhasil diambil!",
                    'status_code' => 200,
                    'status' => 'success',
                ],
            ]);

            $response->assertJsonFragment([
                'name' => $transaction->name,
                'email' => $transaction->email,
                'number' => $transaction->number,
                'address' => $transaction->address,
                'transaction_total' => $transaction->transaction_total,
                'transaction_status' => $transaction->transaction_status,
            ]);
        });
    }
}
