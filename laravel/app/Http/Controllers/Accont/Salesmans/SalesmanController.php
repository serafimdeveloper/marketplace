<?php

namespace App\Http\Controllers\Accont\Salesmans;

use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\SalemanRepository;
use App\Http\Requests\Accont\Salesman\SalesmanStoreRequest;
use App\Http\Requests\Accont\Salesman\SalesmanUpdateRequest;
use Illuminate\Http\Request;

use Illuminate\Container\Container as App;
use Auth;

class SalesmanController extends AbstractController
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function repo(){
        return SalemanRepository::class;
    }

    public function create(){
        return view('accont.salesman');
    }

    /**
     * @param SalesmanStoreRequest $request
     * @return  \Illuminate\Http\RedirectResponse
     * Metodo que salva o vendedor, salva os documentos do mesmo e muda o perfil do usuário como vendedor
     */
    public function store(SalesmanStoreRequest $request){
        $user =  Auth::user();
        $dados = $request->except('photo_document','proof_adress');
        $dados['user_id'] = $user->id;
        if($salesman = $this->repo->store($dados)){
            $dados['photo_document'] = $this->upload($request->photo_document,'imagem/vendedor','D1V'.$salesman->id);
            $dados['proof_adress'] = $this->upload($request->proof_adress,'imagem/vendedor','D2V'.$salesman->id);
            $this->repo->update($dados,$salesman->id);
            flash('Vendedor salvo com sucesso!', 'accept');
            return redirect()->route('accont.salesman.info');
        }
        flash('Ocorreu um erro!', 'error');
        return view('accont.salesman');
    }


    public function edit(){
        $salesman = Auth::user()->salesman;
        return view('accont.salesman', compact('salesman'));
    }

    /**
     * @param SalesmanUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * Metodo que atualiza as informações do usuário
     */
    public function update(SalesmanUpdateRequest $request){
        $user = Auth::user()->salesman;
        $dados = $request->all();
        if($salesman = $this->repo->update($dados,$user->id)){
            flash('Vendedor salvo com sucesso!', 'accept');
        }else{
            flash('Ocorreu um erro!', 'error');
        }
        return redirect()->route('accont.salesman.info');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Metodo que muda o status do vendedor
     */
    public function toogle_user(Request $request){
        $user = Auth::user();
        if(Auth::attempt(['email' => $user->email, 'password' => $request->get('password')])){
            if($user->salesman->active){
                $user->salesman->save(['active' => 0]);
            }else{
                $user->salesman->save(['active' => 1]);
            }
            return response()->json(['status'=>true]);
        }
        return response()->json(['status'=>false]);
    }


    public function destroy(){
        $user = Auth::user();
        if($pendency = $this->check_pending($user->salesman)){
            return response()->json(['salesman'=>$user->salesman, 'pendency'=>$pendency, 'status'=>'pendency']);
        }else{
            if($this->repo->delete($user->salesman->id)){
                flash('Vendedor excluido com sucesso!', 'accept');
                return redirect()->route('accont.home');
            }
        }
        return response()->json(['status'=>false]);
    }

    private function check_pending($salesman){
        return $salesman->store->requests->whereNotNull('close_at')->get();
    }

}