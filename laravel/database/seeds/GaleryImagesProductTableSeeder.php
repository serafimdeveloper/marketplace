<?php
use App\Model\Galery;
use Illuminate\Database\Seeder;

class GaleryImagesProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Galery::class, 5)->create();
    }
}
