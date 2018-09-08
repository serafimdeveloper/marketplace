<?php
use App\Model\Address;
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
        $user = factory(User::class)->create(['email' => 'admin@admin.com', 'password' => bcrypt('12345678'), 'active' => 1, 'type_user' => 'admin']);
        $user->admin()->create([]);
        factory(Address::class)->create(['user_id' => $user->id, 'master' => 1]);
        factory(User::class, 20)->create()->each(function ($u) {
            factory(Address::class)->create(['user_id' => $u->id, 'master' => 1]);
        });
    }
}
