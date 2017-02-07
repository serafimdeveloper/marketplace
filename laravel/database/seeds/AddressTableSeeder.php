<?php
use App\Model\Adress;
use Illuminate\Database\Seeder;

class AddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Adress::class, 1)->create();
    }
}
