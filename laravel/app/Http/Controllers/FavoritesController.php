<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:48
 */

namespace App\Http\Controllers;


use App\Model\Cart;
use App\Repositories\FavoritesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
            return response()->json(['msg' => 'Produto removido do seu favorito com sucesso!','status'=>200],200);
        }else{
            $user->favorites()->create(['product_id'=>$product]);
            return response()->json(['msg'=>'Produto adicionado no seu favoritos', 'status'=>201], 201);
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

    public function add_cart(Request $request){

        $this->validate($request, ['favorites' => 'required']);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        foreach($request->favorites as $favorite){
            $cart->add_cart($favorite);
        }
        $request->session()->put('cart', $cart);
        flash('Produto(s) adicionado no carrinho','accept');
        return redirect()->route('pages.cart');
    }
}