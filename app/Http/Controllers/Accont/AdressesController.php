<?php
	namespace App\Http\Controllers\Accont;

	use App\Http\Controllers\Controller;
	use Auth;
	use Correios;
	use App\Model\Adress;
	use App\Http\Requests\Accont\AdressesStoreRequest;

	class AdressesController extends Controller
	{
		protected $adress;

		public function __construct(Adress $adress){
			$this->adress = $adress;
		}

		public function index()
		{

		}

		public function store(AdressesStoreRequest $request){
			$user = Auth::User();
			$adress = $this->adress->fill($request->all());
			if($dados = $user->adresses()->save($adress))
			{
				return json_encode(['status'=>true, 'adress'=>$dados]);
			}
			return json_encode(['status'=>false,'msg'=>'Ocorreu um erro ao criar o endereço !'], 500);
		}

		public function edit($id){
			$adress = $this->adress->find($id);
			return json_encode($adress);
		}

		public function update(AdressesStoreRequest $request, $id){
			$user = Auth::User();
			$adress = $user->adresses()->find($id)->fill($request->all());
			if($adress->save())
			{
				return json_encode(['status'=>true,'adress'=>$adress]);
			}
			return json_encode(['status'=>false,'msg'=>'Ocorreu um erro ao atualizar o endereço !'], 500);
		}

		public function destroy($id){
			$user = Auth::User();
			$adress = $user->adresses()->find($id);
			if($adress->delete())
			{
				return json_encode('status'=>true);
			}
			return json_encode(['status'=>false,'msg'=>'Ocorreu um erro ao excluir o endereço !'], 500);
		}

		public function search_cep($cep){
			return Correios::cep($cep);
		}
	}