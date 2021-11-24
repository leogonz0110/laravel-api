<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        foreach (range(1, 200) as $index) {
            \DB::table('orders')->insert([
                'product_id' => $faker->numberBetween(1, 50),
                'order_by' => $faker->numberBetween(1, 5),
                'quantity' => $faker->numberBetween(1, 20),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
