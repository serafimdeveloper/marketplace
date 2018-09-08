<?php
use App\Model\Address;
use App\Model\Store;
use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Store::class, 5)->create()->each(function ($s) {
            factory(Address::class)->create(['store_id' => $s->id]);
            factory(\App\Model\Product::class, rand(5,10))->create(['store_id' => $s->id])->each(function($p) {
                factory(\App\Model\Gallery::class, rand(1,3))->create(['product_id' => $p->id]);
            });
        });

    }
}
