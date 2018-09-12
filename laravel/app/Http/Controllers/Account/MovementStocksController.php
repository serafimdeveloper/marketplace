<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\AbstractController;
use Illuminate\Container\Container as App;
use App\Model\Product;
use App\Model\TypeMovementStock;
use App\Repositories\BaseRepository;
use App\Repositories\MovementStocksRepository as Repository;
use Illuminate\Http\Request;

class MovementStocksController extends AbstractController
{
    /**
     * @return BaseRepository
     */
    protected $typeMovementStock, $product;

    public function repo(){
        return Repository::class;
    }

    public function __construct(App $app, TypeMovementStock $typeMovementsStock, Product $product)
    {
        parent::__construct($app);
        $this->typeMovementStock = $typeMovementsStock;
        $this->product = $product;
    }

    public function index($type){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_account');
        }
        $where = [];
        if(isset($type)){
            if($typeMovementStock = $this->typeMovementStock->where('slug','=',$type)->first()){
                $where = ['type_movement_stock_id' => $typeMovementStock->id];
            }
        }
        $movements = $this->repo->all($this->columns,$this->with, $where,[],15);
        return view('account.moviment_stocks', compact('movements'));
    }

    public function create($type){

    }

    public function store(Request $request, $type ){
        $dados = $request->all();
        $product = $this->product->find($dados['product_id']);
        if($typeMovementStock = $this->typeMovementStock->where('slug','=',$type)->first()){
            $dados['type_movement_stock_id'] = $typeMovementStock->id;
            if($typeMovementStock->type === 'out'){
                if($dados['count'] <= $product->quantity){
                    $product->decrement('quantity',$dados['count']);
                }else{
                    return response()->json(['msg'=>'A quantidade de produtos insuficientes'],402);
                }
            }else{
                $product->increment('quantity',$dados['count']);
            }

            if($movement_stock = $this->repo->store($dados)){
               return response()->json(['product'=>$product->quantity],201);
            }
        }
        return response()->json(['msg'=>'erro ao fazer a movimentação'],500);
    }

    public function show($id){

    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }

}