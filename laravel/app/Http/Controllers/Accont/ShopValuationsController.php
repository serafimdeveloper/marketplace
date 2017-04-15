<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 17/02/2017
 * Time: 02:54
 */

namespace App\Http\Controllers\Accont;


use App\Http\Controllers\AbstractController;
use App\Repositories\Accont\RequestsRepository;
use App\Repositories\Accont\ShopValuationsRepository;
use Illuminate\Container\Container as App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShopValuationsController extends AbstractController
{

    public function __construct(App $app)
    {
        parent::__construct($app);
        if(Gate::denies('is_active')){
            return redirect()->route('page.confirm_accont');
        }
    }

    public function repo(){
        return ShopValuationsRepository::class;
    }

    protected $with = ['store','user','request'];

    public function store(Request $request, RequestsRepository $order, $id){
        $this->validate($request,
            [
                'comment'=>'required|min:5|max:500',
                'note_products' => 'required',
                'note_attendance'=>'required',
                'request_status'=>'required'
            ],
            [
                'comment.required' => 'A comentários é obrigatório',
                'comment.min' => 'A quantidade mínima de caracteres é 4',
                'comment.max' => 'A quantidade máxima é de 500 caracteres',
                'note_products.required' => 'Avaliáção de produtos é obrigatória',
                'note_attendance.required' => 'Avaliáção de atendimento obrigatória',
                'request_status.required' => 'O status do pedido deve ser informado!'
            ]
        );

        $data = $request->all();
        $data['request_id'] = $id;

        if($data['request_status'] == 'devolvido' && !$data['return_reason']){
            return response()->json(['msg'=>'Informe o motivo da devolução'],404);
        }
        if($this->repo->store($data)){
            if($data['request_status'] == 'devolvido'){
                $order->update(['request_status_id' => 7], $id);
            }else{
                $order->update(['request_status_id' => 8], $id);
            }
            return response()->json(['status'=>true],201);
        }
        return response()->json(['msg'=>'Erro ao avaliar'],500);
    }


}