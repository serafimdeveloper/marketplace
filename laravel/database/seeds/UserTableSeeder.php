<?php
use App\Model\Adress;
use App\Model\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(User::class, 1)->create();
        factory(User::class, 20)->create()->each(function ($u) {
            $u->addresses()->save(factory(Adress::class)->make());
        });
    }
}
