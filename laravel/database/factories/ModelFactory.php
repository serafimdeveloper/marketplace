<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Model\Adress;
use App\Model\Category;
use App\Model\CountOrder;
use App\Model\Freight;
use App\Model\Galery;
use App\Model\Message;
use App\Model\MessageType;
use App\Model\Payment;
use App\Model\Product;
use App\Model\ProductRequest;
use App\Model\Request;
use App\Model\RequestStatus;
use App\Model\Salesman;
use App\Model\Store;
use App\Model\User;
use Carbon\Carbon;
use Faker\Generator;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\DB;

$factory->define(User::class, function (Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'birth' => $faker->date('Y-m-d','now'),
        'genre' => $faker->randomElement(array('M','F')),
        'phone' => $faker->numerify('(##) ####-####'),
        'cpf' => $faker->unique()->numerify('###.###.###-##'),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'confirm_token' => str_random(20),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Salesman::class, function(Generator $faker){
    $folder = DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'vendedor';
    return [
        'user_id' => function(){
            $element = User::where('type', '=', 'client')->get()->random();
            $element->save(['type' => 'salesman']);

            return $element->id;
        },
        'moip' => function (array $post) {
            return User::find($post['user_id'])->name;
        },
        'cpf' => function (array $post) {
            return User::find($post['user_id'])->cpf;
        },
        'facebook' => $faker->url,
        'phone' => $faker->numerify('(##) ####-####'),
        'whatsapp' => $faker->cellphoneNumber,
        'cellphone' => $faker->cellphoneNumber,
        'photo_document' => $faker->image(storage_path(). $folder, 640, 480, 'cats', false),
        'proof_adress' => $faker->image(storage_path() . $folder, 640, 480, 'cats', false),
        'active' => 0
    ];
});

$factory->define(Store::class, function(Generator $faker){
    $folder = DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'loja';
    return [
        'salesman_id' => function(){
            return factory(Salesman::class, 1)->create()->id;
        },
        'name' => $faker->unique()->word(),

        'type_salesman' => $faker->randomElement(array('F','J')),
        'cnpj' => $faker->numerify('##.###.###/####-##'),
        'fantasy_name' => $faker->unique()->sentence(2),
        'social_name' => $faker->unique()->name . ' ltda',
        'slug' => $faker->unique()->slug,
        'about' => $faker->text(500),
        'exchange_policy' => $faker->text(500),
        'freight_policy' => $faker->text(500),
        'logo_file' => $faker->image(storage_path(). $folder, 640, 480, 'cats', false),
        'rate' => $faker->randomFloat(2, 0, 5),
        'active' => 0,
        ];
    });
$factory->define(Adress::class, function(Generator $faker){
    return [
        'name' => $faker->name,
        'zip_code' => $faker->postcode,
        'state' => $faker->stateAbbr,
        'city' => $faker->city,
        'public_place' => $faker->streetName,
        'neighborhood' => $faker->word,
        'number' => $faker->buildingNumber,
        'complements' => null,
        'master' => 0
    ];
});

$factory->define(Category::class, function(Generator $faker){
    return [
        'name' => $faker->unique()->word,
        'slug' => $faker->slug(2),
        'menu' => 0,
        'active' => 1
    ];
});

$factory->define(Product::class, function(Generator $faker){
    return [
        'store_id' => function(){
            $element = Store::all()->random();
            return $element->id;
        },
        'category_id' => function(){
            $element = Category::all()->random();
            return $element->id;
        },
        'name' => $faker->unique()->sentence(3),
        'price' => $faker->randomFloat(2, 50, 200),
        'price_out_discount' => $faker->randomFloat(2, 1, 50),
        'deadline' => $faker->numberBetween(1, 15),
        'free_shipping' => $faker->randomElement(array('0','1')),
        'minimum_stock' => $faker->numberBetween(1, 50),
        'details' => $faker->text(500),
        'length_cm' => $faker->randomFloat(2, 1, 500),
        'width_cm' => $faker->randomFloat(2, 1, 500),
        'height_cm' => $faker->randomFloat(2, 1, 500),
        'weight_gr' => $faker->randomFloat(2, 1, 500),
        'diameter_cm' => $faker->randomFloat(2, 1, 500),
        'slug' => $faker->unique()->slug,
        'active' => 1
    ];
});

$factory->define(Galery::class, function(Generator $faker){
    $folder = DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'produto';
    return [
        'image' => $faker->image(storage_path(). $folder, 640, 480, 'cats', false),
    ];
});

$factory->define(Payment::class, function(Generator $faker){
    return [
        'name' => $faker->unique()->randomElement([
            'Cartão',
            'Boleto',
            'Moip'
        ]),
    ];

});

$factory->define(CountOrder::class, function(){
    return [
        'count' => 0
    ];

});

$factory->define(Freight::class, function(Generator $faker){
    return [
        'name' => $faker->unique()->randomElement([
            'PAC',
            'SEDEX',
            'Frete Grátis'
        ]),
        'code' => function(array $data){
            switch($data['name']){
                case 'PAC':
                    return 41106;
                    break;
                case 'SEDEX':
                    return 40010;
                    break;
                default:
                    return null;
                    break;
            }
        }
    ];
});

$factory->define(RequestStatus::class, function(Generator $faker){
    return [

        'description' => $faker->unique()->randomElement([
            'Aguardando pagamento',
            'Compra incompleta',
            'Aguardando envio',
            'Aguardando chegada',
            'Aguardando avaliação',
            'Negociação concluída',
            'Pedido devolvido',
            'Compra cancelada'
        ]),

        'trigger' => function(array $data){
            switch($data['description']){
                case 'Aguardando pagamento':
                    return 'warning';
                    break;
                case 'Compra incompleta':
                    return 'error';
                    break;
                case 'Aguardando envio':
                    return 'warning';
                    break;
                case 'Aguardando chegada':
                    return 'notice';
                    break;
                case 'Aguardando avaliação':
                    return 'notice';
                    break;
                case 'Negociação concluída':
                    return 'accept';
                    break;
                case 'Pedido devolvido':
                    return 'default';
                    break;
                case 'Compra cancelada':
                    return 'error';
                    break;
            }
        }
    ];

});

$factory->define(Request::class, function(Generator $faker){
    return [
        'store_id' => function(){
            $element = Store::all()->random();
            return $element->id;
        },
        'user_id' => function(){
            $element = User::all()->random();
            return $element->id;
        },
        'adress_id' => function(array $data){
            $addressUser = Adress::find($data['user_id']);
            return $addressUser->id;
        },
        'freight_id' => function(){
            $element = Freight::all()->random();
            return $element->id;
        },
        'payment_id' => function(){
            $element = Payment::all()->random();
            return $element->id;
        },
        'request_status_id' => function(){
            $status = RequestStatus::all()->random();
            return $status->id;
        },
        'key' => function(){
            $count = CountOrder::first();
            $value = $count->count + 1;
            $key = substr(date('M'), 0, 1) .  date('Y') . date('d') . $value;

            $count->update(['count' => $value]);

            return $key;
        },
        'freight_price' => function(array $data) use($faker){
            $element = Freight::find($data['freight_id']);


            if($element->code == ''){
                return 0.00;
            }else{
                return $faker->randomFloat(2, 1, 50);
            }
        },
        'send_date' => $faker->date('Y-m-d'),
        'settlement_date' => $faker->date('Y-m-d', 'now'),
        'cancellation_date' => null,
        'number_installments' => 1,
        'payment_reference' => null,
        'note' => $faker->text(255),
        'amount' => $faker->randomFloat(2, 1, 50)
    ];
});

$factory->define(MessageType::class, function(Generator $faker){
    return[
        'description' => $faker->unique()->randomElement([
            'u/u',
            'u/v',
            'v/u',
            'v/v',
            'u/a',
            'a/u',
            'v/a',
            'a/v'
        ]),
    ];
});

$factory->define(Message::class, function(Generator $faker){
    return[
        'sender_id' => function(){
            $element = User::all()->random();
            return $element->id;
        },
        'recipient_id' => function(array $data){
            $element = User::where('id', '!=', $data['sender_id'])->distinct()->inRandomOrder()->first();
            return $element->id;
        },
        'message_type_id' => function(array $data){
            $element = MessageType::all()->random();
            return $element->id;
        },
        'request_id' => function(array $data){
            $m = Message::all()->sortByDesc('id')->first();
            $order = Request::all()->random();
            if(!Message::all()->first()){
                return $order->id;
            }else{
                if(!$m->request_id){
                    return $order->id;
                }else{
                    return null;
                }
            }

        },
        'product_id' => function(array $data){
            if(!$data['request_id']){
                $element = Product::all()->random();
                return $element->id;
            }else{
                return null;
            }
        },
        'message_id' => function(array $data){
            $m = Message::all()->sortByDesc('id')->first();
            if(Message::all()->first()){
                if(!$m->message_id){

                    return Message::all()->random()->id;
                }else{
                    return null;
                }
            }else{
                return null;
            }
        },
        'title' => $faker->sentence(6),
        'content' => $faker->text(500),
        'status' => 'received'
    ];
});