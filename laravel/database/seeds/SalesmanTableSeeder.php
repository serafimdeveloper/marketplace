<?php
use App\Model\Salesman;
use Illuminate\Database\Seeder;

class SalesmanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 16; $i++){
            factory(Salesman::class)->create();
        }

    }
}
