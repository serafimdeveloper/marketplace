<?php
use App\Model\Freight;
use Illuminate\Database\Seeder;

class FreightTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Freight::class, 3)->create();
    }
}
