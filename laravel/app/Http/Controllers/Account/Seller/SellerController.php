<?php

namespace App\Http\Controllers\Account\Sellers;

use App\Http\Controllers\AbstractController;
use App\Package\Moip\lib\MoIPClient;
use App\Http\Requests\Account\Seller\SellerStoreRequest;
use App\Http\Requests\Account\Seller\SellerUpdateRequest;
use App\Repositories\Account\SellerRepository;
use Illuminate\Http\Request;

use Illuminate\Container\Container as App;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SellerController extends AbstractController
{
    public function repo(){
        return SellerRepository::class;
    }

    public function create(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        return view('account.seller');
    }

    /**
     * @param SellerStoreRequest $request
     * @return  \Illuminate\Http\RedirectResponse
     * Metodo que salva o vendedor, salva os documentos do mesmo e muda o perfil do usuário como vendedor
     */
    public function store(SellerStoreRequest $request){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $user =  Auth::user();
        $dados = $request->except('photo_document','proof_address');
        $dados['user_id'] = $user->id;
        $moipClient = new MoIPClient;
        $result = $moipClient->curlGet(env('MOIP_TOKEN') . ":" . env('MOIP_KEY'), env('MOIP_URL') . "/ws/alpha/VerificarConta/" . $dados['moip']);
        $xml = simplexml_load_string($result->xml);
        $xmlData = $xml->RespostaVerificarConta;

        if($xmlData->Status == 'Inexistente'){
            flash('Login moip inexistente!', 'error');
            return redirect()->route('account.seller.info');
        }else if($xmlData->Descricao == 'Pessoal'){
            flash('É necessário uma conta de Negócios no moip para se tornar vendedor!', 'error');
            return redirect()->route('account.seller.info');
        }else{
            if($seller = $this->repo->store($dados)){
                $dados['photo_document'] = $this->upload($request->photo_document,'img/vendedor','D1V'.$seller->id);
                $dados['proof_address'] = $this->upload($request->proof_address,'img/vendedor','D2V'.$seller->id);
                $this->repo->update($dados,$seller->id);
                $user->update(['type_user'=>'seller']);
                flash('Vendedor salvo com sucesso!', 'accept');
                return redirect()->route('account.seller.info');
            }
        }
        flash('Ocorreu um erro!', 'error');
        return view('account.seller');
    }


    public function edit(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        if ($user = Auth::user()) {
            if(!$user->cpf){
                flash('É necessário cadastrar seu cpf para se tornar um vendedor', 'warning');
                return redirect()->route('account.home');
            }elseif(!isset(Auth::user()->addresses[0])){
                flash('É necessário cadastrar um endereço para continuar', 'warning');
                return redirect()->route('account.home');
            }
        }
        $seller = Auth::user()->seller;
        $isDocs['address'] = (isset($seller->proof_address) && $seller->proof_address  ? $seller->proof_address : false);
        $isDocs['document'] = (isset($seller->photo_document) && $seller->photo_document  ? $seller->photo_document : false);

        return view('account.seller', compact('seller', 'isDocs'));
    }

    /**
     * @param SellerUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * Metodo que atualiza as informações do usuário
     */
    public function update(SellerUpdateRequest $request){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $user = Auth::user()->seller;
        $dados = $request->all();
        $moipClient = new MoIPClient;
        $result = $moipClient->curlGet(env('MOIP_TOKEN') . ":" . env('MOIP_KEY'), env('MOIP_URL') . "/ws/alpha/VerificarConta/" . $dados['moip']);
        $xml = simplexml_load_string($result->xml);
        $xmlData = $xml->RespostaVerificarConta;

        if($xmlData->Status == 'Inexistente'){
            flash('Login moip inexistente!', 'error');
            return redirect()->route('account.seller.info');
        }else if($xmlData->Descricao == 'Pessoal'){
            flash('É necessário uma conta de Negócios no moip para se tornar vendedor!', 'error');
            return redirect()->route('account.seller.info');
        }else{
            if($seller = $this->repo->update($dados, $user->id)){
                if(isset($dados['photo_document'])){
                    Storage::delete('img/vendedor/' . $seller->photo_document);
                    $dados['photo_document'] = $this->upload($request->photo_document, 'img/vendedor', 'D1V' . $seller->id);
                }
                if(isset($dados['proof_address'])){
                    Storage::delete('img/vendedor/' . $seller->proof_address);
                    $dados['proof_address'] = $this->upload($request->proof_address, 'img/vendedor', 'D2V' . $seller->id);
                }
                $this->repo->update($dados, $seller->id);
                $user->update(['type_user' => 'seller']);
                flash('Vendedor salvo com sucesso!', 'accept');
            }else{
                flash('Ocorreu um erro!', 'error');
            }
        }
        return redirect()->route('account.seller.info');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Metodo que muda o status do vendedor
     */
    public function toogle_user(Request $request){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $user = Auth::user();
        if(Auth::attempt(['email' => $user->email, 'password' => $request->get('password')])){
            if($user->seller->active){
                $user->seller->save(['active' => 0]);
            }else{
                $user->seller->save(['active' => 1]);
            }
            return response()->json(['status'=>true],200);
        }
        return response()->json(['status'=>false],500);
    }


    public function destroy(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_account');
        }
        $user = Auth::user();
        if($pendency = $this->check_pending($user->seller)){
            return response()->json(['seller'=>$user->seller, 'pendency'=>$pendency, 'status'=>'pendency']);
        }else{
            if($this->repo->delete($user->seller->id)){
                flash('Vendedor excluido com sucesso!', 'accept');
                return redirect()->route('account.home');
            }
        }
        return response()->json(['status'=>false],500);
    }

    private function check_pending($seller){
        return $seller->store->requests->whereNotNull('close_at')->get();
    }

}