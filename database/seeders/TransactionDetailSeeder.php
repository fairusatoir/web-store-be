<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class TransactionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $limit = 8;
            for ($i = 0; $i < $limit; $i++) {
                TransactionDetail::create([
                    'transactions_id' => Transaction::pluck('id')->random(),
                    'products_id' => Product::pluck('id')->random(),
                ]);
            }
            DB::commit();
            echo "\t" . $limit . " Transaction Detail has been created\n";
        } catch (Exception $e) {
            echo "\tTransaction Detail has error " . $e->getMessage() . "\n";
        }
    }
}
