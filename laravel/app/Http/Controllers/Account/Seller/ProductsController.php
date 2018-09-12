<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Account\Sellers;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Request;
use App\Model\Product;
use App\Model\Store;
use App\Model\TypeMovementStock;
use Illuminate\Container\Container as App;
use App\Http\Requests\Account\Seller\ProductsUpdateRequest;
use App\Model\Gallery;
use App\Repositories\Account\ProductsRepository;
use App\Model\Category;
use App\Http\Requests\Account\Seller\ProductsStoreRequest;
use Auth;
use DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ProductsController extends AbstractController {
    protected $with = ['category', 'store', 'galleries'];
    protected $gallery, $category;

    public function __construct(App $app, Gallery $gallery, Category $category){
        parent::__construct($app);
        $this->category = $category;
        $this->gallery = $gallery;
    }

    public function repo(){
        return ProductsRepository::class;
    }

    public function index(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        if(Gate::denies('vendedor')){
            return redirect()->route('account.home');
        }
        $page = Input::get('page');
        if($store = Auth::user()->seller->store){
            $products = $this->repo->all($this->columns, $this->with, ['store_id' => $store->id], [], 5, $page);

            return view('account.products', compact('products'));
        }
        flash('Antes de cadastrar um produto tem que criar uma loja!', 'warning');

        return redirect()->route('account.seller.stores');
    }

    public function create(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        if(Gate::denies('vendedor')){
            return redirect()->route('account.home');
        }
        $categories = $this->category->whereNull('category_id')->orderBy('name', 'ASC')->pluck('name', 'id');
        $stores = (Auth::user()->admin ? Store::all()->pluck('name', 'id') : null);
        return view('account.product_info', compact('categories', 'stores'));
    }

    public function store(ProductsStoreRequest $request){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $store_id = isset($request->store_id) ? $request->store_id : Auth::user()->seller->store->id;
        $dados = $request->all();
        $dados['price_out_discount'] = ($request->price_out_discount) ? $request->price_out_discount : null;
        $dados['diameter_cm'] = ($request->diameter_cm) ? $request->diameter_cm : 0;
        $dados['store_id'] = $store_id;
        $dados['category_id'] = ($request->subcategory_id) ? $request->subcategory_id : $request->category_id;
        if($product = $this->repo->store($dados)){
            $value = 1;
            for($i = 0; $i < 5; $i++){
                if(isset($request->{'image_' . $i})){
                    $image = $this->upload($request->{'image_' . $i}, 'img/produto', 'P' . $product->id . 'I' . $value);
                    $product->galleries()->create(['image' => $image]);
                }
                $value++;
            }
            flash('Produto criado com sucesso!', 'accept');

            return redirect()->route('account.seller.products.edit', ['id' => $product->id])->withInput();
        }
        flash('Erro ao criar o produto!', 'error');

        return redirect()->route('account.seller.product.create')->withInput();
    }

    public function edit(TypeMovementStock $typeMovementStock, $id){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        if(Gate::denies('produtc_access', Product::find($id))){
            return redirect()->route('account.home');
        }
        $categories = $this->category->whereNull('category_id')->orderBy('name', 'ASC')->pluck('name', 'id');
        $product = $this->repo->get($id, $this->columns, $this->with);
        $category_id = isset($product->category->category_id) ? $product->category->category_id : $product->category->id;
        $subcategories = $this->category->where('category_id', $category_id)->orderBy('name', 'ASC')->pluck('name', 'id');
        $galleries = $product->galleries->toArray();
        $typemovements = $typeMovementStock->pluck('name', 'slug');

        return view('account.product_info', compact('categories', 'product', 'galleries', 'typemovements', 'subcategories'));
    }

    public function update(ProductsUpdateRequest $request, $id){

        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        if(Gate::denies('produtc_access', Product::find($id))){
            return redirect()->route('account.home');
        }
        $dados = $request->except('type_operation_stock');
        $dados['price_out_discount'] = ($request->price_out_discount) ? $request->price_out_discount : null;
        $dados['diameter_cm'] = ($request->diameter_cm) ? $request->diameter_cm : null;
        $dados['category_id'] = ($request->subcategory_id) ? $request->subcategory_id : $request->category_id;
        if($product = $this->repo->update($dados, $id)){
            $value = 1;
            for($i = 0; $i < 5; $i++){
                if(isset($request->{'image_' . $i})){
                    if($gallery = $this->gallery->where('image', $request->{'image_name_' . $i})->first()){
                        if(Storage::disk('local')->exists('img/produto/' . $gallery->image)){
                            Storage::delete('img/produto/' . $gallery->image);
                        }
                        $image = $this->upload($request->{'image_' . $i}, 'img/produto', 'P' . $id . 'I' . $value);
                        $gallery->fill(['image' => $image])->save();
                    }else{
                        $image = $this->upload($request->{'image_' . $i}, 'img/produto', 'P' . $id . 'I' . $value);
                        $product->galleries()->create(['image' => $image]);
                    }
                }
                $value++;
            }
            flash('Produto atualizado com sucesso!', 'accept');
            return redirect()->back();
        }
        flash('Erro ao criar o produto!', 'error');
        return redirect()->route('account.seller.product.edit')->withInput();
    }

    public function removeImage($image){
        if($gallery = $this->gallery->find($image)){
            if(Storage::disk('local')->exists('img/produto/' . $gallery->image)){
                Storage::delete('img/produto/' . $gallery->image);
            }
            $gallery->delete($image);

            return response()->json(['status' => true], 200);
        }

        return response()->json(['msg' => 'Erro ao deletar a imagem'], 500);
    }

    public function desactive($id){
        if(Gate::denies('produtc_access', Product::find($id))){
            return redirect()->route('account.home');
        }
        if($product = $this->repo->get($id)){
            if($product->active){
                $product->fill(['active' => 0])->save();

                return response()->json(['status' => true], 200);
            }

            return response()->json(['msg' => 'Erro ao desativar, o produto já está desativado'], 500);
        }

        return response()->json(['msg' => 'Erro ao desativar'], 500);
    }

    public function destroy($id){
        if(Gate::denies('produtc_access', Product::find($id))){
            return redirect()->route('account.home');
        }
        if($products = $this->repo->get($id, ['*'], ['requests'])){
            if ($products->requests->count()) {
                $products->delete();
                return response()->json(['status' => true]);

            } else {
                $products->forceDelete();
                return response()->json(['status' => true]);

            }
        }

        return response()->json(['msg' => 'Produto não encontrado'], 404);
    }
}

