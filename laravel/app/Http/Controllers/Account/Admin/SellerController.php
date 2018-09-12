<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 12/04/2017
 * Time: 20:30
 */

namespace App\Http\Controllers\Account\Admin;

use App\Repositories\Account\SellerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SellerController extends AbstractAdminController {
    public function __construct(SellerRepository $repo){
        $this->repo = $repo;
    }

    public function index(Request $request){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_account');
        }
        $this->ordy = ['name' => 'ASC'];
        $this->title = 'Vendedores Cadastrado no Sistema';
        $this->placeholder = 'Pesquisar por nome ou email';
        $data = $this->search($request, 'sellers');
        if($request->ajax()){
            return view('account.report.presearch', $data);
        }

        return view('account.report.search', $data);
    }

    public function show($id){
        if(Gate::denies('admin')){
            return redirect()->route('page.confirm_account');
        }
        $this->with = ['user', 'store'];
        if($result = $this->getByRepoId($id)){
            $result->read = 1;
            $result->save();
            $type = 'vendedor';

            return view('layouts.parties.alert_seller_info', compact('result', 'type'));
        }

        return response()->json(['msg' => 'Erro ao encontrar o vendedor'], 404);
    }

    public function change($id){
        if($seller = $this->repo->get($id)){
            if($seller->active){
                $seller->update(['active' => 0]);
            }else{
                $seller->update(['active' => 1]);
                send_mail('emails.welcome', ['email' => $seller->user->email, 'name' => $seller->user->name], 'Vendedor, seja bem vindo ao Popmartin!');
            }
            return response()->json(['status'=>$seller->active],200);
        }

        return response()->json(['status' => false], 500);
    }


    public function update(Request $request, $id){
        if($seller = $this->repo->get($id)) {
            $seller->update($request->all());
            return response()->json(['status' => true], 200);
        }
        return response()->json(['status' => false, 500]);
    }

    public function destroy($id){
        if($seller = $this->repo->get($id)){
            if($seller->delete()){
                if($seller->store){
                    $seller->store->products->each(function($product){
                        if($product->requests){
                            $product->delete();
                        }else{
                            $product->forceDelete();
                        }
                    });
                    $seller->store->delete();
                }
                return response()->json([], 204);
            }

        }
        return response()->json(['status' => false], 500);
    }
}