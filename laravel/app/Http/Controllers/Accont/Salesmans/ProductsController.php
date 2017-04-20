<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Accont\Salesmans;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Request;
use App\Model\Product;
use App\Model\Store;
use App\Model\TypeMovementStock;
use Illuminate\Container\Container as App;
use App\Http\Requests\Accont\Salesman\ProductsUpdateRequest;
use App\Model\Galery;
use App\Repositories\Accont\ProductsRepository;
use App\Model\Category;
use App\Http\Requests\Accont\Salesman\ProductsStoreRequest;
use Auth;
use DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class ProductsController extends AbstractController {
    protected $with = ['category', 'store', 'galeries'];
    protected $galery, $category;

    public function __construct(App $app, Galery $galery, Category $category){
        parent::__construct($app);
        $this->category = $category;
        $this->galery = $galery;
    }

    public function repo(){
        return ProductsRepository::class;
    }

    public function index(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        if(Gate::denies('admin') || Gate::denies('vendedor')){
            return redirect()->route('accont.home');
        }
        $page = Input::get('page');
        if($store = Auth::user()->salesman->store){
            $products = $this->repo->all($this->columns, $this->with, ['store_id' => $store->id], [], 5, $page);

            return view('accont.products', compact('products'));
        }
        flash('Antes de cadastrar um produto tem que criar uma loja!', 'warning');

        return redirect()->route('accont.salesman.stores');
    }

    public function create(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        if(Gate::denies('admin') || Gate::denies('vendedor')){
            return redirect()->route('accont.home');
        }
        $categories = $this->category->whereNull('category_id')->orderBy('name', 'ASC')->pluck('name', 'id');
        $stores = (Auth::user()->admin ? Store::all()->pluck('name', 'id') : null);
        return view('accont.product_info', compact('categories', 'stores'));
    }

    public function store(ProductsStoreRequest $request){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $store_id = isset($request->store_id) ? $request->store_id : Auth::user()->salesman->store->id;
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
                    $product->galeries()->create(['image' => $image]);
                }
                $value++;
            }
            flash('Produto criado com sucesso!', 'accept');

            return redirect()->back();
        }
        flash('Erro ao criar o produto!', 'error');

        return redirect()->route('accont.salesman.product.create')->withInput();
    }

    public function edit(TypeMovementStock $typeMovementStock, $id){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        if(Gate::denies('produtc_access', Product::find($id))){
            return redirect()->route('accont.home');
        }
        $categories = $this->category->whereNull('category_id')->orderBy('name', 'ASC')->pluck('name', 'id');
        $product = $this->repo->get($id, $this->columns, $this->with);
        $category_id = isset($product->category->category_id) ? $product->category->category_id : $product->category->id;
        $subcategories = $this->category->where('category_id', $category_id)->orderBy('name', 'ASC')->pluck('name', 'id');
        $galeries = $product->galeries->toArray();
        $typemovements = $typeMovementStock->pluck('name', 'slug');

        return view('accont.product_info', compact('categories', 'product', 'galeries', 'typemovements', 'subcategories'));
    }

    public function update(ProductsUpdateRequest $request, $id){

        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        if(Gate::denies('produtc_access', Product::find($id))){
            return redirect()->route('accont.home');
        }
        $dados = $request->except('type_operation_stock');
        $dados['price_out_discount'] = ($request->price_out_discount) ? $request->price_out_discount : null;
        $dados['diameter_cm'] = ($request->diameter_cm) ? $request->diameter_cm : null;
        $dados['category_id'] = ($request->subcategory_id) ? $request->subcategory_id : $request->category_id;
        if($product = $this->repo->update($dados, $id)){
            $value = 1;
            for($i = 0; $i < 5; $i++){
                if(isset($request->{'image_' . $i})){
                    if($galery = $this->galery->where('image', $request->{'image_name_' . $i})->first()){
                        if(Storage::disk('local')->exists('img/produto/' . $galery->image)){
                            Storage::delete('img/produto/' . $galery->image);
                        }
                        $image = $this->upload($request->{'image_' . $i}, 'img/produto', 'P' . $id . 'I' . $value);
                        $galery->fill(['image' => $image])->save();
                    }else{
                        $image = $this->upload($request->{'image_' . $i}, 'img/produto', 'P' . $id . 'I' . $value);
                        $product->galeries()->create(['image' => $image]);
                    }
                }
                $value++;
            }
            flash('Produto atualizado com sucesso!', 'accept');
            return redirect()->back();
        }
        flash('Erro ao criar o produto!', 'error');
        return redirect()->route('accont.salesman.product.edit')->withInput();
    }

    public function removeImage($image){
        if($galery = $this->galery->find($image)){
            if(Storage::disk('local')->exists('img/produto/' . $galery->image)){
                Storage::delete('img/produto/' . $galery->image);
            }
            $galery->delete($image);

            return response()->json(['status' => true], 200);
        }

        return response()->json(['msg' => 'Erro ao deletar a imagem'], 500);
    }

    public function desactive($id){
        if(Gate::denies('produtc_access', Product::find($id))){
            return redirect()->route('accont.home');
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
            return redirect()->route('accont.home');
        }
        if($products = $this->repo->get($id, ['*'], ['requests'])){
            /* if ($requests = $products->requests) {
                 return response()->json(compact('requests'),406);
             } else {*/
            $products->delete();

            return response()->json(['status' => true]);
            // }
        }

        return response()->json(['msg' => 'Produto não encontrado'], 404);
    }
}

