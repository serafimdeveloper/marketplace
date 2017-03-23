<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 17/02/2017
 * Time: 02:54
 */

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\ShopValuationsRepository;
use Illuminate\Http\Request;

class ShopValuationsController extends AbstractController
{
    public function repo(){
        return ShopValuationsRepository::class;
    }

    protected $with = ['store','user','request'];

    public function index(){
        $all = $this->repo->all($this->columns,$this->with);
    }

    public function show($id){

    }

    public function create(){

    }

    public function store(Request $request, $id){
        $this->validate($request,['comment'=>'required|min:5|max:500'],['comment.required' => 'A comentários é obrigatório','comment.min' => 'A quantidade mínima de caracteres é 5',
            'comment.max' => 'A quantidade máxima é de 500 caracteres']);
        $data = $request->all();
        $data['request_id'] = $id;
        if($this->repo->store($data)){
            return response()->json(['status'=>true],201);
        }
        return response()->json(['msg'=>'Erro ao avaliar'],500);
    }

    public function edit($id){

    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }

}