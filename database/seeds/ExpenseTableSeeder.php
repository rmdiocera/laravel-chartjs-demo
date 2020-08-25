<?php

use App\Expense;
use Illuminate\Database\Seeder;

class ExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Expense::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 3; $i++) {
            Expense::create([
                'branch_id' => $faker->numberBetween(1, 3),
                'expense_type_id' => 3,
                'quantity' => $faker->numberBetween(1, 3),
                'created_at' => $faker->dateTimeBetween('-6 months', '-3 months')
            ]);
        }
    }
}
