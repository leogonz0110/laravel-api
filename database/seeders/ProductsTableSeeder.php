<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        foreach (range(1, 50) as $index) {
            \DB::table('products')->insert([
                'name' => $faker->company,
                'stock' => $faker->numberBetween(0, 1000),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
        
    }
}
