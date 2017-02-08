<?php
use App\Model\ProductRequest;
use App\Model\Request;
use Illuminate\Database\Seeder;

class RequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(Request::class)->create()
        factory(Request::class)->create()->each(function($rp){
            $rp->products->save(new ProductRequestTableSeeder);
        });
    }
}
