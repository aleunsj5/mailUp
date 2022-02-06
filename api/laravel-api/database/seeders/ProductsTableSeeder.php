<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;
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
        Products::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Products::create([
                'name' => $faker->name,
                'description' => $faker->paragraph,
                'image'=>$faker->image(),
                'brand'=>$faker->sentence,
                'price'=>$faker->numberBetween($min = 1000, $max = 9000),
                'price_sale'=>$faker->numberBetween($min = 1350, $max = 11500),
                'category'=>$faker->randomElement(['MacBook', 'Acer', 'Asus','HP','Lenovo']),
                'stock'=>$faker->numberBetween($min = 0, $max = 100),
                'creation_date'=>Carbon::now(),
            ]);
        }
    }
}
