<?php
use App\Model\RequestStatus;
use Illuminate\Database\Seeder;

class RequestStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!RequestStatus::find(1)){
            factory(RequestStatus::class, 7)->create();
        }
    }
}
