<?php

namespace Database\Seeders;

use Exception;
use App\Models\Product;
use App\Models\Transaction;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $faker = Faker::create();
            $limit = 15;
            for ($i = 0; $i < $limit; $i++) {
                $transaction = Transaction::create([
                    'uuid' => "TRX" . date('Ymd') . $faker->randomNumber(4),
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'number' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'transaction_total' => $faker->numberBetween(2, 25),
                    'transaction_status' => $faker->randomElement(['PENDING', 'SUCCESS', 'FAILED']),
                ]);

                TransactionDetail::create([
                    'transactions_id' => $transaction->id,
                    'products_id' => Product::pluck('id')->random(),
                ]);
            }
            DB::commit();
            echo "\t" . $limit . " Transaction has been created\n";
        } catch (Exception $e) {
            DB::rollBack();
            echo "\tTransaction has error " . $e->getMessage() . "\n";
        }
    }
}
