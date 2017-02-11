<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 31/01/2017
 * Time: 14:48
 */

namespace App\Http\Controllers\Accont\Salesmans;


use App\Http\Controllers\AbstractController;
use App\Model\TypeMovementStock;
use Illuminate\Container\Container as App;
use App\Http\Requests\Accont\Salesman\ProductsUpdateRequest;
use App\Model\Galery;
use App\Repositories\Accont\ProductsRepository;
use App\Model\Category;
use App\Http\Requests\Accont\Salesman\ProductsStoreRequest;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;

class ProductsController extends AbstractController
{
    protected $with = ['category', 'store','galeries'];
    protected $galery, $category;

    public function __construct(App $app, Galery $galery, Category $category )
    {
        parent::__construct($app);
        $this->category = $category;
        $this->galery = $galery;
    }

    public function repo()
    {
        return ProductsRepository::class;
    }

    public function index()
    {
        if ($store = Auth::user()->salesman->store) {
            $products = $this->repo->all($this->columns, $this->with, ['store_id' => $store->id], [], 5);
            return view('accont.products', compact('products'));
        }
        flash('Antes de cadastrar um produto tem que criar uma loja!', 'warning');
        return redirect()->route('accont.salesman.stores');

    }

    public function create()
    {
        $categories = $this->category->pluck('name', 'id');
        return view('accont.product_info', compact('categories'));
    }

    public function store(ProductsStoreRequest $request)
    {
        $store = Auth::user()->salesman->store;
        $dados = $request->all();
        $dados['price_out_discount'] = isset($request->price_out_discount) ? $request->price_out_discount : 'null';
        $dados['store_id'] = $store->id;
        if ($product = $this->repo->store($dados)) {
            for ($i = 0; $i < 5; $i++) {
                if(isset($request->{'image_'.$i})){
                    $image = $this->upload($request->{'image_'.$i},'img/produto','P'.$product->id.'I'.$i++);
                    $product->galeries()->create(['image'=>$image]);
                }
            }
            flash('Produto criado com sucesso!', 'accept');
            return redirect()->route('accont.salesman.products.index');
        }
        flash('Erro ao criar o produto!', 'error');
        return redirect()->route('accont.salesman.product.create')->withInput();
    }

    public function edit( TypeMovementStock $typeMovementStock, $id)
    {
        $categories = $this->category->pluck('name', 'id');
        $product = $this->repo->get($id, $this->columns, $this->with);
        $galeries = $product->galeries->toArray();
        $typemovements = $typeMovementStock->pluck('name','slug');
        return view('accont.product_info', compact('categories', 'product', 'galeries','typemovements'));
    }

    public function update(ProductsUpdateRequest $request, $id)
    {
        $dados = $request->except('type_operation_stock');
        $dados['price_out_discount'] = isset($request->price_out_discount) ? $request->price_out_discount : 'null';
        if($product = $this->repo->update($dados,$id)){
            for ($i = 0; $i < 5; $i++) {
                if(isset($request->{'image_'.$i})){
                    if($galery =  $this->galery->where('image', $request->{'image_name_'.$i})->first()){
                        if(Storage::disk('local')->exists('img/produto/'.$galery->image)){
                            Storage::delete('img/produto/'.$galery->image);
                        }
                        $image = $this->upload($request->{'image_'.$i},'img/produto','P'.$id.'I'.$i++);
                        $galery->save(['image'=>$image]);
                    }else {
                        $image = $this->upload($request->{'image_'.$i},'img/produto','P'.$id.'I'.$i++);
                        $product->galeries()->create(['image'=>$image]);
                    }
                }
            }
            flash('Produto atualizado com sucesso!', 'accept');
            return redirect()->route('accont.salesman.products.index');
        }
        flash('Erro ao criar o produto!', 'error');
        return redirect()->route('accont.salesman.product.edit')->withInput();
    }
}