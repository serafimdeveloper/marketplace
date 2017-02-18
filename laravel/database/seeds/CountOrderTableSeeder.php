<?php
use App\Model\CountOrder;
use Illuminate\Database\Seeder;

class CountOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if($count = CountOrder::first() == false){
            factory(CountOrder::class)->create();
        }

    }
}
