<?php
use App\Model\Adress;
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
        factory(Store::class, 5)->create();
//        factory(Store::class, 1)->create()->each(function ($s) {
//            $s->address()->save(factory(Adress::class)->make([
//                'user_id' => $s->find
//            ]));
//        });
    }
}
