<?php
	namespace App\Http\Controllers\Account;

	use App\Http\Controllers\AbstractController;
    use App\Http\Requests\Request;
    use Auth;
	use Correios;
	use App\Repositories\Account\AddressesRepository;
	use App\Http\Requests\Account\AddressesStoreRequest;

	class AddressesController extends AbstractController
	{
        public function repo()
        {
           return AddressesRepository::class;
        }

        public function index()
		{
		    $this->check_master();
            $addresses = $this->repo->all($this->columns,$this->with,['user_id'=>$this->user->id],['master'=>'DESC']);
            return $addresses;
		}

		public function store(AddressesStoreRequest $request, $action){
            $dados = $this->save($request, $action);
			if($address = $this->repo->store($dados))
			{
			    $this->check_master();
				return response()->json(['status'=>true, 'address'=>$address,'action'=>$action]);
			}
			return response()->json(['status'=>false,'msg'=>'Ocorreu um erro ao criar o endereço !'], 500);
		}

		public function edit($action, $id){
			$address = $this->repo->get($id);
            return response()->json($address);
		}

		public function update(AddressesStoreRequest $request, $action, $id){
            $dados = $this->save($request, $action);
            if($address = $this->repo->update($dados, $id))
			{
                $this->check_master();
                return response()->json(['address'=>$address,'action'=>$action]);
			}
			return response()->json(['msg'=>'Ocorreu um erro ao atualizar o endereço !'], 500);
		}

		public function destroy($id){
		    $user = Auth::user();
		    if($user->addresses->count() > 1 ){
                if($this->repo->delete($id)) {
                    $this->check_master();
                    return response()->json(['status'=>true],200);
                }
                return response()->json(['msg'=>'Ocorreu um erro ao excluir o endereço !'], 500);
            }
            return response()->json(['msg' => 'Necessário ter pelo menos um endereço'],403);
		}

		public function search_cep($cep){
		    $zip_code = Correios::cep($cep);
		    if(count($zip_code)){
                return  response()->json($zip_code);
            }
            return response()->json(['msg'=>'Cep Inválido'],404);
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
                if($user->addresses->count()){
                    if(isset($request->master)){
                        $this->change_master($user->addresses);
                        $dados['master'] = 1;
                    }else{
                        $dados['master'] = 0;
                    }
                }else{
                   $dados['master'] = 1;
                }
                $dados['user_id'] = $user->id;
            }else{
                $dados['store_id'] = $user->seller->store->id;
            }
            return $dados;
        }

        public function get_mycep(Request $request){
            if($address = $request->address){
                $zip_code = Auth::user()->addresses->find($address)->zip_code;
                return  response()->json($zip_code);
            }
            return response()->json(['msg'=>'Endereço inválido'],404);
        }

        private function check_master(){
            $user = Auth::user();
            if($user->addresses->count()){
                if(!$user->addresses->where('master',1)->first()){
                    $user->addresses->first()->update(['master'=>1]);
                }
            }
        }

    }

	