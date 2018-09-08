<?php
use App\Model\TypeFreight;
use Illuminate\Database\Seeder;

class TypeFreightTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeFreight::insert([
            [ 'name' => 'PAC', 'code' => '04510', 'active' => 1 ],
            [ 'name' => 'SEDEX', 'code' => '04014', 'active' => 1 ],
            [ 'name' => 'Frete Grátis', 'code' => '', 'active' => 1 ]
        ]);
    }
}
