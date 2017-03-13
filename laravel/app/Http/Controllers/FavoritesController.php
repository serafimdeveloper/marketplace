<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:48
 */

namespace App\Http\Controllers;


use App\Repositories\FavoritesRepository;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends AbstractController
{

    public function repo()
    {
        return FavoritesRepository::class;
    }

    public function index(){
        $favorites = $this->repo->getProductsFavorites();
        return view('pages.favorites', compact('favorites'));
    }

    public function store($product){
        $user = Auth::user();
        if($favorite = $user->favorites()->where('product_id', $product)->first()){
            $favorite->delete();
            return response()->json(['msg' => 'Produto removido do seu favorito com sucesso!'],200);
        }else{
            $user->favorites()->create(['product_id'=>$product]);
            return response()->json(['msg'=>'Produto adicionado no seu favoritos'], 201);
        }
        return response()->json(['msg'=>'Ocorreu um erro'],500);
    }

    public function destroy($product){
        $user = Auth::user();
        if($favorite = $user->favorites()->where('product_id',$product)->first()){
            $favorite->delete();
            return response()->json(['msg' => 'Produto removido do seu favorito com sucesso!'],200);
        }
        return response()->json(['msg' => 'Erro ao remover o produto do seu favorito'],500);

    }
    public function cart(){

    }
}