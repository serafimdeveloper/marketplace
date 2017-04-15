<?php

namespace App\Http\Controllers\Accont\Salesmans;

use App\Http\Controllers\AbstractController;
use App\Package\Moip\lib\MoIPClient;
use App\Http\Requests\Accont\Salesman\SalesmanStoreRequest;
use App\Http\Requests\Accont\Salesman\SalesmanUpdateRequest;
use App\Repositories\Accont\SalesmanRepository;
use Illuminate\Http\Request;

use Illuminate\Container\Container as App;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SalesmanController extends AbstractController
{
    public function repo(){
        return SalesmanRepository::class;
    }

    public function create(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        return view('accont.salesman');
    }

    /**
     * @param SalesmanStoreRequest $request
     * @return  \Illuminate\Http\RedirectResponse
     * Metodo que salva o vendedor, salva os documentos do mesmo e muda o perfil do usuário como vendedor
     */
    public function store(SalesmanStoreRequest $request){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $user =  Auth::user();
        $dados = $request->except('photo_document','proof_adress');
        $dados['user_id'] = $user->id;

        $moipClient = new MoIPClient;
        $result = $moipClient->curlGet(env('MOIP_TOKEN') . ":" . env('MOIP_KEY'), env('MOIP_URL') . "/ws/alpha/VerificarConta/" . $dados['moip']);
        $xml = simplexml_load_string($result->xml);
        $xmlData = $xml->RespostaVerificarConta;

        if($xmlData->Status == 'Inexistente'){
            flash('Login moip inexistente!', 'error');
            return redirect()->route('accont.salesman.info');
        }else if($xmlData->Descricao == 'Pessoal'){
            flash('É necessário uma conta de Negócios no moip para se tornar vendedor!', 'error');
            return redirect()->route('accont.salesman.info');
        }else{
            if($salesman = $this->repo->store($dados)){
                $dados['photo_document'] = $this->upload($request->photo_document,'img/vendedor','D1V'.$salesman->id);
                $dados['proof_adress'] = $this->upload($request->proof_adress,'img/vendedor','D2V'.$salesman->id);
                $this->repo->update($dados,$salesman->id);
                $user->update(['type_user'=>'salesman']);
                flash('Vendedor salvo com sucesso!', 'accept');
                return redirect()->route('accont.salesman.info');
            }
        }
        flash('Ocorreu um erro!', 'error');
        return view('accont.salesman');
    }


    public function edit(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        if ($user = Auth::user()) {
            if(!$user->cpf){
                flash('É necessário cadastrar seu cpf para se tornar um vendedor', 'warning');
                return redirect()->route('accont.home');
            }elseif(!isset(Auth::user()->addresses[0])){
                flash('É necessário cadastrar um endereço para continuar', 'warning');
                return redirect()->route('accont.home');
            }
        }
        $salesman = Auth::user()->salesman;
        $isDocs['address'] = (isset($salesman->proof_adress) && $salesman->proof_adress  ? $salesman->proof_adress : false);
        $isDocs['document'] = (isset($salesman->photo_document) && $salesman->photo_document  ? $salesman->photo_document : false);

        return view('accont.salesman', compact('salesman', 'isDocs'));
    }

    /**
     * @param SalesmanUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * Metodo que atualiza as informações do usuário
     */
    public function update(SalesmanUpdateRequest $request){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $user = Auth::user()->salesman;
        $dados = $request->all();
        $moipClient = new MoIPClient;
        $result = $moipClient->curlGet(env('MOIP_TOKEN') . ":" . env('MOIP_KEY'), env('MOIP_URL') . "/ws/alpha/VerificarConta/" . $dados['moip']);
        $xml = simplexml_load_string($result->xml);
        $xmlData = $xml->RespostaVerificarConta;

        if($xmlData->Status == 'Inexistente'){
            flash('Login moip inexistente!', 'error');
            return redirect()->route('accont.salesman.info');
        }else if($xmlData->Descricao == 'Pessoal'){
            flash('É necessário uma conta de Negócios no moip para se tornar vendedor!', 'error');
            return redirect()->route('accont.salesman.info');
        }else{
            if($salesman = $this->repo->update($dados, $user->id)){
                if(isset($dados['photo_document'])){
                    Storage::delete('img/vendedor/' . $salesman->photo_document);
                    $dados['photo_document'] = $this->upload($request->photo_document, 'img/vendedor', 'D1V' . $salesman->id);
                }
                if(isset($dados['proof_adress'])){
                    Storage::delete('img/vendedor/' . $salesman->proof_adress);
                    $dados['proof_adress'] = $this->upload($request->proof_adress, 'img/vendedor', 'D2V' . $salesman->id);
                }
                $this->repo->update($dados, $salesman->id);
                $user->update(['type_user' => 'salesman']);
                flash('Vendedor salvo com sucesso!', 'accept');
            }else{
                flash('Ocorreu um erro!', 'error');
            }
        }
        return redirect()->route('accont.salesman.info');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Metodo que muda o status do vendedor
     */
    public function toogle_user(Request $request){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $user = Auth::user();
        if(Auth::attempt(['email' => $user->email, 'password' => $request->get('password')])){
            if($user->salesman->active){
                $user->salesman->save(['active' => 0]);
            }else{
                $user->salesman->save(['active' => 1]);
            }
            return response()->json(['status'=>true],200);
        }
        return response()->json(['status'=>false],500);
    }


    public function destroy(){
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
        $user = Auth::user();
        if($pendency = $this->check_pending($user->salesman)){
            return response()->json(['salesman'=>$user->salesman, 'pendency'=>$pendency, 'status'=>'pendency']);
        }else{
            if($this->repo->delete($user->salesman->id)){
                flash('Vendedor excluido com sucesso!', 'accept');
                return redirect()->route('accont.home');
            }
        }
        return response()->json(['status'=>false],500);
    }

    private function check_pending($salesman){
        return $salesman->store->requests->whereNotNull('close_at')->get();
    }

}