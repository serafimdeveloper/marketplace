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
        factory(Request::class, 20)->create()->each(function ($r) {
            $products = $r->store->products->random(rand(2,4));
            $r->products()->attach($this->listProducts($products));
            $r->fill([
                'amount' => $r->products->reduce(function($carry, $product) {
                    return $carry + $product->pivot->amount;
                }, $r->freight_price)
            ])->save();
        });
    }

    private function listProducts($products){
        $array = [];
        $products->each(function($p) use(&$array) {
           $quantity = rand(1,3);
               $array[$p->id] = ['quantity' => $quantity, 'unit_price' => $p->price, 'amount' => $p->price * $quantity ];
        });
        return $array;
    }
}
