<?php
use App\Model\Product;
use App\Model\Request;
use Illuminate\Database\Seeder;

class ProductRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Cria uma instância da classe Faker/Factory
        $faker = Faker\Factory::create();
        //Factory Request
        factory(Request::class,20)->create()->each(function($request) use($faker){
            Product::all()->random(3)->each(function($product) use($request, $faker){
                $quantity = $faker->randomDigitNotNull;
                $unit_price = $faker->randomFloat(2, 5, 100);
                $amount = $unit_price * $quantity;
                $request->products()->save($product,['quantity'=> $quantity, 'unit_price'=>$unit_price, 'amount'=>$amount]);
            });
        });
    }
}
