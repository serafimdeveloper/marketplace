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
use App\Model\Address;
use App\Model\Category;
use App\Model\CountOrder;
use App\Model\TypeFreight;
use App\Model\Gallery;
use App\Model\Message;
use App\Model\MessageType;
use App\Model\TypePayment;
use App\Model\Product;
use App\Model\Request;
use App\Model\RequestStatus;
use App\Model\Seller;
use App\Model\Store;
use App\Model\TypeMovementStock;
use App\Model\User;
use Faker\Generator;

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

$factory->define(Seller::class, function(Generator $faker){
    $folder = DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'vendedor';
    $user = factory(User::class)->create(['type_user' => 'salesman']);
    return [
        'user_id' => $user->id,
        'moip' => $user->name,
        'facebook' => $faker->url,
        'phone' => $faker->numerify('(##) ####-####'),
        'whatsapp' => $faker->cellphoneNumber,
        'cellphone' => $faker->cellphoneNumber,
        'photo_document' => $faker->image(storage_path(). $folder, 640, 480, 'people', false),
        'proof_address' => $faker->image(storage_path() . $folder, 640, 480, 'city', false),
        'active' => 0
    ];
});

$factory->define(Store::class, function(Generator $faker){
    $folder = DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'loja';
    $salesman = factory(Seller::class)->create(['active' => 1]);
    return [
        'seller_id' => $salesman->id,
        'name' => $faker->unique()->word(),
        'type_seller' => $faker->randomElement(array('F','J')),
        'cnpj' => $faker->numerify('##.###.###/####-##'),
        'fantasy_name' => $faker->unique()->sentence(2),
        'social_name' => $faker->unique()->name . ' ltda',
        'about' => $faker->text(500),
        'exchange_policy' => $faker->text(500),
        'freight_policy' => $faker->text(500),
        'logo_file' => $faker->image(storage_path(). $folder, 640, 480, 'transport', false),
        'rate' => $faker->randomFloat(2, 0, 5),
        'active' => 0,
    ];
});

$factory->define(Address::class, function(Generator $faker){
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
        'menu' => 0,
        'active' => 1
    ];
});

$factory->define(Product::class, function(Generator $faker){
    $store = Store::all()->random();
    $category = Category::all()->random();
    return [
        'store_id' => $store->id,
        'category_id' => $category->id,
        'name' => $faker->unique()->sentence(3),
        'price' => $faker->randomFloat(2, 100, 200),
        'price_out_discount' => $faker->randomFloat(2, 50, 100),
        'deadline' => $faker->numberBetween(1, 15),
        'quantity' => $faker->numberBetween(1, 20),
        'free_shipping' => $faker->randomElement(array('0','1')),
        'minimum_stock' => $faker->numberBetween(1, 50),
        'details' => $faker->text(500),
        'length_cm' => $faker->numberBetween(16, 80),
        'width_cm' => $faker->numberBetween(11, 100),
        'height_cm' => $faker->numberBetween(2, 50),
        'weight_gr' => $faker->numberBetween(1, 5000),
        'active' => 1
    ];
});

$factory->define(Gallery::class, function(Generator $faker){
    $folder = DIRECTORY_SEPARATOR . 'app'. DIRECTORY_SEPARATOR . 'img'. DIRECTORY_SEPARATOR . 'produto';
    $product = Product::all()->random();
    return [
        'product_id' => $product->id,
        'image' => $faker->image(storage_path(). $folder, 640, 480, 'technics', false)
    ];
});

$factory->define(CountOrder::class, function(){
    return [
        'count' => 0
    ];

});

$factory->define(Request::class, function(Generator $faker){
    $store = Store::all()->random();
    $user = User::where('id','<>',$store->seller->user_id)->has('addresses')->get()->random();
    return [
        'store_id' => $store->id,
        'user_id' => $user->id,
        'type_freight_id' => function(){
            $element = TypeFreight::all()->random();
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
            $element = TypeFreight::find($data['type_freight_id']);
            if($element->code == ''){
                return 0.00;
            }else{
                return $faker->randomFloat(2, 1, 50);
            }
        },
        'deadline' => rand(1,5),
        'address_receiver' => json_encode($user->addresses->random(1)),
        'address_sender' => json_encode($store->address),
        'send_date' => $faker->date('Y-m-d'),
        'phone' => $faker->numerify('(##) ####-####'),
        'settlement_date' => null,
        'cancellation_date' => null,
        'note' => $faker->text(255),
        'amount' => $faker->randomFloat(2, 1, 50)
    ];
});

$factory->define(Message::class, function(Generator $faker){
    $type_recept = $faker->randomElement(['App\\Model\\User', 'App\\Model\\Store']);
    $type_send  = $faker->randomElement(['App\\Model\\User', 'App\\Model\\Store' ]);
    $recept = app($type_recept);
    $send  = app($type_send);
    return[
        'sender_type' => $type_send,

        'sender_id' => function(array $data) use($send){
            $element = $send->all()->random();
            return $element->id;
        },
        'recipient_id' => function(array $data) use($recept){
            $element = $recept->all()->random();
            return $element->id;
        },
        'recipient_type' => $type_recept,
        'request_id' => function(array $data){
            $m = Message::all()->sortByDesc('id')->first();
            $order = Request::where('user_id', $data['recipient_id'])->distinct()->inRandomOrder()->first();

            if(!Message::all()->first()){
                return $order->id;
            }else{
                if(!$m->request_id && $order){
                    return $order->id;
                }else{
                    return null;
                }
            }

        },
        'product_id' => function(array $data){
            if(!$data['request_id']){

                $sender = Seller::where('user_id', $data['sender_id'])->get();
                $recipient = Seller::where('user_id', $data['recipient_id'])->get();
                $storeSender = ($sender->first() ? Store::where('salesman_id', $sender->first()->id)->get()->first() : null);
                $storeRecipient = ($recipient->first() ? Store::where('salesman_id', $recipient->first()->id)->get()->first() : null);

                if($storeSender || $storeRecipient){
                    $storeSender = ($storeSender ? $storeSender->id : null);
                    $storeRecipient = ($storeRecipient ? $storeRecipient->id : null);
                    $element = Product::where('store_id', $storeSender)->orWhere('store_id', $storeRecipient)->inRandomOrder()->first();
                    if($element){
                        return $element->id;
                    }else{
                        return null;
                    }

                }else{
                    return null;
                }
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