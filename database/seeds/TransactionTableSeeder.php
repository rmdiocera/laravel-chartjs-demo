<?php

use App\Transaction;
use Illuminate\Database\Seeder;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 80; $i++) {
            Transaction::create([
                'branch_id' => $faker->numberBetween(1, 3),
                'product_id' => $faker->numberBetween(1, 7),
                'quantity' => $faker->numberBetween(1, 3),
                'created_at' => $faker->dateTimeBetween('-6 months', '-3 months')
            ]);
        }
    }
}
