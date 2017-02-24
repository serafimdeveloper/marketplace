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
            <td><a href="{{url($store->slug)}}" class="fontem-12 c-green-avocadodark">{{ $store->name }}</a></td>
            <td>{{ $store->salesman->user->name }}</td>
        </tr>
    @empty
        <tr colspan="2"><h4>Nenhuma Loja Encontrada</h4></tr>
    @endforelse
    </tbody>
</table>
{!! $result->render() !!}
@section('script')
    <script>
        $(document).on('click', '.pagination a', function (event) {
            $('li').removeClass('active');
            $(this).parent('li').addClass('active');
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var data = 'name=' + $(".jq-input-search").val();
            getData(page, data);
        });
    </script>
@endsection
