@if($type === 'users')
    <table id="jq-search-table-result" class="table table-action">
        <thead>
        <tr>
            <th>Nome</th>
            <th class="t-medium">E-mail</th>
            <th class="t-medium">Último acesso</th>
            <th class="t-small">Pedidos</th>
            <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
        </tr>
        </thead>

        <tbody>
        @forelse($result as $user)
            <tr class="trUser{{ $user->id }}">
                <td>{{$user->name.' '.$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->last_access->format('d/m/Y H:i:s')}}</td>
                <td>{{$user->requests->count()}}</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info" data-alertbox="jq-info-user" data-type="users" data-id="{{$user->id}}">detalhes</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5"><h3>Nenhum usuário encontrado!</h3></td>
            </tr>
        @endforelse
        </tbody>
    </table>

@elseif($type === 'sallesmans')
    <table id="jq-search-table-result" class="table table-action">
        <thead>
        <tr>
            <th>Nome</th>
            <th class="t-medium">Loja</th>
            <th class="t-medium">Local</th>
            <th class="t-small">Produtos</th>
            <th class="t-medium">Moip</th>
            <th class="t-small">Status</th>
            <th class="t-small">Taxa</th>
            <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
        </tr>
        </thead>

        <tbody>

        @forelse($result as $salesman)
            <tr {!! !$salesman->read ? 'class="t-unread"' : '' !!}>
                <td>{{$salesman->user->name.' '.$salesman->user->last_name}}</td>
                <td>{{isset($salesman->store) ? $salesman->store->name : '-'}}</td>
                <td>{{isset($salesman->store->adress) ? $salesman->store->adress->city.'/'.$salesman->store->adress->state : '-'}}</td>
                <td>{{isset($salesman->store) ? $salesman->store->products->count() : '-'}}</td>
                <td>{{$salesman->moip}}</td>
                <td>{{($salesman->active) ? 'habilitado' :'desabilitado'}}</td>
                <td>{{number_format($salesman->comission,2,',','.')}}%</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info" data-alertbox="jq-info-salesman" data-type="salesmans" data-id="{{$salesman->id}}">detalhes</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8"> Nenhum vendedor encontrado!</td>
            </tr>
        @endforelse
        </tbody>
    </table>

@elseif($type === 'products')
    <table id="jq-search-table-result" class="table table-action">
        <thead>
        <tr>
            <th class="t-medium" style="width: 60px;">Imagem</th>
            <th>Nome</th>
            <th class="t-medium">Vendedor</th>
            <th class="t-small">Estoque</th>
            <th class="t-small">Visível</th>
            <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
        </tr>
        </thead>

        <tbody>
        @forelse($result as $product)
            <tr id="pr{{ $product->id }}">
                <td><img src="{{ url('imagem/produto/'.$product->galeries->first()->image) }}" alt="{{$product->name}}" title="{{$product->name}}"></td>
                <td>{{$product->name}}</td>
                <td>{{$product->store->salesman->user->name.' '.$product->store->salesman->user->last_name}}<br> <a href="{{route('pages.store',[$product->store->slug])}}" style="color: #B71C1C">{{$product->store->name}}</a></td>
                <td class="txt-center">{{$product->quantity}}</td>
                <td class="t-draft txt-center">{{($product->active) ? 'sim':'não'}}</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info" data-alertbox="jq-info-product" data-type="products" data-id="{{$product->id}}">detalhes</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7"><h3>Nenhum produto encontrado!</h3></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@elseif($type === 'categories')
    <table class="table table-action">
        <thead>
        <tr>
            <th class="t-medium">Nome</th>
            <th class="t-medium">categoria PAI</th>
            <th class="t-medium">url</th>
            <th class="t-medium txt-center">Principal</th>
            <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
        </tr>
        </thead>
        <tbody>
        @forelse($result as $category)
            <tr id="category_01">
                <td>{{$category->name}}</td>
                <td>{{($category->category_id) ? $category->name : ''}}</td>
                <td>{{$category->slug}}</td>
                <td class="txt-center">
                    <div class="form-modern">
                        <div class="checkbox-container">
                            <div class="checkboxies">
                                <label class="checkbox" style="border: none;padding: 0;">
                                    <span><span class="fa {{ ($category->menu ? 'fa-check-square-o' : 'fa-square-o') }}"></span></span>
                                    {!! Form::checkbox('status', $category->menu, ($category->menu ? true : false), ['class' => 'jq-category-menu', 'data-id' => $category->id, 'data-token' => csrf_token()]) !!}
                                </label>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="alertbox-open t-btn t-edit jq-info" data-alertbox="alert-newcategory" data-type="categories" data-id="{{$category->id}}">editar</a>
                    <a href="javascript:void(0)" class="t-btn t-remove jq-remove-category" data-type="categories" data-token="{{ csrf_token() }}" data-id="{{$category->id}}">remover</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Nenhuma Categoria Cadastrada</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@elseif($type === 'sales')
    <table id="jq-search-table-result" class="table table-action">
        <thead>
        <tr>
            <th class="t-medium">Pedido</th>
            <th class="t-medium">Data</th>
            <th>Cliente</th>
            <th>Vendedor</th>
            <th class="t-small">Valor</th>
            <th class="t-small">Comissão</th>
            <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
        </tr>
        </thead>

        <tbody>
        @forelse($result as $sales)
            <tr>
                <td>#{{$sales->key}}</td>
                <td>{{$sales->created_at->format('d/m/Y H:i:s')}}</td>
                <td>{{$sales->user->name.' '.$sales->user->last_name}}</td>
                <td>{{$sales->store->name}}</td>
                <td>{{real($sales->amount)}}</td>
                <td>{{($sales->commission_amount) ? real($sales->commission_amount) : '-'}}</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info" data-alertbox="jq-info-sale" data-type="sales" data-id="{{$sales->id}}">detalhes</a>
                </td>
            </tr>
        @empty
            <tr >
                <td colspan="7"><h3>Nenhuma Vendas encontradas </h3></td>
            </tr>
        @endforelse
        </tbody>
    </table>

@elseif($type === 'banners')
    <table id="jq-search-table-result" class="table table-action">
        <thead>
        <tr>
            <th class="t-small">Imagem</th>
            <th class="t-small">Nome</th>
            <th class="t-medium">Descrição</th>
            <th class="t-medium">url</th>
            <th class="t-small">Início</th>
            <th class="t-small">Fim</th>
            <th class="t-small txt-center"><i class="fa fa-gears"></i></th>
        </tr>
        </thead>
        <tbody>
        @forelse($result as $banner)
            <tr>
                <td><img src="{{url('imagem/loja/'.$banner->store->logo_file)}}"></td>
                <td>{{$banner->store->name}}</td>
                <td>{{$banner->description}}</td>
                <td>{{$banner->store->slug}}</td>
                <td>{{$banner->date_start->format('d/m/Y H:i:s')}}</td>
                <td>{{$banner->date_end->format('d/m/Y H:i:s')}}</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-edit jq-info" data-alertbox="alert-banner" data-type="banners" data-id="{{$banner->id}}">editar</a>
                    <a href="javascript:void(0)" class="t-btn t-remove jq-remove-banner" data-type="banners" data-id="{{$banner->id}}" data-token="{{ csrf_token() }}">remover</a>
                </td>
            </tr>
        @empty
            <tr >
                <td colspan="7"><h3>Nenhum banner cadastrado</h3></td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endif
{!! $result->render() !!}
