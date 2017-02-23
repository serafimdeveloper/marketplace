<table id="jq-search-table-result" class="table table-action">
    <thead>
    <tr>
        <th class="t-medium">Loja</th>
        <th class="t-medium">Vendedor</th>
    </tr>
    </thead>
    <tbody>
    @forelse($result as $store)
        <tr>
            <td><a href="{{url($store->slug)}}" class="fontem-12 c-green-avocadodark">{{ $store->name }}</a> </td>
            <td>{{ $store->salesman->user->name }}</td>
        </tr>
    @empty
        <tr colspan="2"><h4>Nenhuma Loja Encontrada</h4></tr>
    @endforelse
    </tbody>
</table>
{!! $result->render() !!}
