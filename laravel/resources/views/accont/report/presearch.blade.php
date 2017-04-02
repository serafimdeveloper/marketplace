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
            <tr>
                <td>{{$user->name.' '.$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->last_access->format('d/m/Y H:i:s')}}</td>
                <td>{{$user->requests->count()}}</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-user" data-user="{{$user->id}}">detalhes</a>
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
            <tr>
                <td>{{$salesman->user->name}}</td>
                <td>{{isset($salesman->store) ? $salesman->store->name : '-'}}</td>
                <td>{{isset($salesman->store) ? $salesman->store->adress->city.'/'.$salesman->store->adress->state : '-'}}</td>
                <td>{{isset($salesman->store) ? $salesman->store->products->count() : '-'}}</td>
                <td>{{$salesman->moip}}</td>
                <td>{{($salesman->status) ? 'habilitado' :'desabilitado'}}</td>
                <td>{{number_format($salesman->comission,2,',','.')}}%</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-user" data-user="{{$salesman->id}}">detalhes</a>
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
            <tr>
                <td><img src="{{ url('imagem/produto/'.$product->galeries->first()->image) }}" alt="{{$product->name}}" title="{{$product->name}}"></td>
                <td>{{$product->name}}</td>
                <td>{{$product->store->salesman->user->name.' '.$product->store->salesman->user->last_name}}<br> <a href="{{route('pages.store',[$product->store->slug])}}" style="color: #B71C1C">{{$product->store->name}}</a></td>
                <td class="txt-center">{{$product->quantity}}</td>
                <td class="t-draft txt-center">{{($product->active) ? 'sim':'não'}}</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-product" data-product="{{$product->id}}">detalhes</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7"><h3>Nenhum produto encontrado!</h3></td>
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
                <td>{{real($sales->amount * ($sales->store->salesman->comission/100))}}</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-popmartin jq-info-sales" data-sales="{{$sales->id}}">detalhes</a>
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
                <td>{{$banner->date_start}}</td>
                <td>{{$banner->date_end}}</td>
                <td class="txt-center">
                    <a href="javascript:void(0)" class="t-btn t-edit jq-new-banner" data-banner="{{$banner->id}}">editar</a>
                    <a href="javascript:void(0)" class="t-btn t-remove">remover</a>
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
