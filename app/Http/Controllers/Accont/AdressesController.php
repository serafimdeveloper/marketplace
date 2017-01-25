<?php
	namespace App\Http\Controllers\Accont;

	use App\Http\Controllers\Controller;
	use Auth;
	use Correios;
	use App\Repositories\Accont\AdressesRepository as Repository;
	use App\Http\Requests\Accont\AdressesStoreRequest;

	class AdressesController extends Controller
	{
		protected $repo, $user;

		public function __construct(Repository $repo){
			$this->repo = $repo;
            $this->user = Auth::user();
		}

		public function index()
		{
            $adresses = $this->repo->all(null,null,['user_id'=>$this->user->id]);
            return $adresses;
		}

		public function store(AdressesStoreRequest $request){
			if($request->get('master')){
				$this->change_master($this->user->adresses);
			}			
			if($dados = $this->user->adresses()->fill($request->all())->save())
			{
				return json_encode(['status'=>true, 'adress'=>$dados]);
			}
			return json_encode(['status'=>false,'msg'=>'Ocorreu um erro ao criar o endereço !'], 500);
		}

		public function edit($id){
			$adress = $this->repo->get($id);
			return json_encode($adress);
		}

		public function update(AdressesStoreRequest $request, $id){
			$adress = $this->user->adresses()->find($id)->fill($request->all());
			if($request->get('master')){
				$this->change_master($this->user->adresses);
			}	
			if($adress->save())
			{
				return json_encode(['status'=>true,'adress'=>$adress]);
			}
			return json_encode(['status'=>false,'msg'=>'Ocorreu um erro ao atualizar o endereço !'], 500);
		}

		public function destroy($id){
			$adress = $this->user->adresses()->find($id);
			if($adress->delete())
			{
				return json_encode(['status'=>true]);
			}
			return json_encode(['status'=>false,'msg'=>'Ocorreu um erro ao excluir o endereço !'], 500);
		}

		public function search_cep($cep){
			return Correios::cep($cep);
		}

		private function change_master($collection){
			$filtered = $collection->each(function($item){
				if($item->master === 1){
					$item->update(['master'=>0]);
				}
			});
		}
	}

	