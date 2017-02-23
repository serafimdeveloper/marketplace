<?php
	namespace App\Http\Controllers\Accont;

	use App\Http\Controllers\AbstractController;
	use Auth;
	use Correios;
	use App\Repositories\Accont\AdressesRepository;
	use App\Http\Requests\Accont\AdressesStoreRequest;

	class AdressesController extends AbstractController
	{
        public function repo()
        {
           return AdressesRepository::class;
        }

        public function index()
		{
            $adresses = $this->repo->all($this->columns,$this->with,['user_id'=>$this->user->id],['master'=>'DESC']);
            return $adresses;
		}

		public function store(AdressesStoreRequest $request, $action){
            $dados = $this->save($request, $action);
			if($adress = $this->repo->store($dados))
			{
				return response()->json(['status'=>true, 'adress'=>$adress,'action'=>$action]);
			}
			return response()->json(['status'=>false,'msg'=>'Ocorreu um erro ao criar o endereço !'], 500);
		}

		public function edit($action, $id){
			$adress = $this->repo->get($id);
            return response()->json($adress);
		}

		public function update(AdressesStoreRequest $request, $action, $id){
            $dados = $this->save($request, $action);
            if($adress = $this->repo->update($dados, $id))
			{
				return response()->json(['adress'=>$adress,'action'=>$action]);
			}
			return response()->json(['msg'=>'Ocorreu um erro ao atualizar o endereço !'], 500);
		}

		public function destroy($id){
			if($this->repo->delete($id))
			{
				return response()->json(['status'=>true],200);
			}
			return response()->json(['msg'=>'Ocorreu um erro ao excluir o endereço !'], 500);
		}

		public function search_cep($cep){
			return  response()->json(Correios::cep($cep));
		}

		private function change_master($collection){
			 $collection->each(function($item){
				if($item->master === 1){
					$item->update(['master'=>0]);
				}
			 });
		}

		private function save($request, $action){
            $user = Auth::user();
            $dados = $request->except('master');
            if($action === 'user'){
                if(isset($request->master)){
                    $this->change_master($user->addresses);
                    $dados['master'] = 1;
                }else{
                    $dados['master'] = 0;
                }
                $dados['user_id'] = $user->id;
            }else{
                $dados['store_id'] = $user->salesman->store->id;
            }
            return $dados;
        }

    }

	