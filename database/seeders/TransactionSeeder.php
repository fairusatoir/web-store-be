<?php

namespace Database\Seeders;

use Exception;
use App\Models\Transaction;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
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
            $limit = 5;
            for ($i = 0; $i < $limit; $i++) {
                Transaction::create([
                    'uuid' => "TRX" . date('Ymd') . $faker->randomNumber(4),
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'number' => $faker->phoneNumber,
                    'address' => $faker->address,
                    'transaction_total' => $faker->randomFloat(2, 2, 20),
                    'transaction_status' => $faker->randomElement(['PENDING', 'SUCCESS', 'FAILED']),
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
