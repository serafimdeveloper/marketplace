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
        for($i = 0; $i < 14; $i++){
            factory(Store::class)->create();
        }

    }
}
