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

@section('script')
    <script>
        $(document).ready(function(){
       /**
        * Procura de loja em tempo real no painel
        */
        $(document).on('keyup', '.jq-input-search',function () {
            var data = 'name=' + $(this).val();
            getData(1, data);
        });

       $(document).on('click', '.pagination a',function(event){
           $('li').removeClass('active');
           $(this).parent('li').addClass('active');
           event.preventDefault();
           var page=$(this).attr('href').split('page=')[1];
           var data = 'name='+ $(".jq-input-search").val();
           getData(page, data);
       });

       $(window).on('hashchange', function() {
           if (window.location.hash) {
               var page = window.location.hash.replace('#', '');
               var data = 'name='+ $(".jq-input-search").val();
               if (page == Number.NaN || page <= 0) {
                   return false;
               }else{
                   getData(page, data);
               }
           }
       });
    });
       function getData(page, data){
            $.ajax({
                url: '/accont/searchstore?page='+page,
                type: "get",
                data: data,
                datatype: "html",
                beforeSend: function(){
                    $('#jq-search-table-result tbody').html("<tr><td colspan=\"2\"><i class='fa fa-spin fa-spinner'></i> procurando...</td></tr>");
                }
            }).done(function(data){
                $("#result").empty().html(data);
                location.hash = page;
            }).fail(function(jqXHR, ajaxOptions, thrownError){
                alertify.error(response.responseJSON.msg);
            });
       }
    </script>

@endsection