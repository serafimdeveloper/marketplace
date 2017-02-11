<?php
use App\Model\Galery;
use App\Model\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 10)->create()->each(function($g){
            for($i = 0; $i < 5; $i++){
                $g->galeries()->save(factory(Galery::class)->make());
            }
        });
    }
}
