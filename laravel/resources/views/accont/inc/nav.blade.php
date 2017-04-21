@section('css')
    <link rel="stylesheet" href="{{asset('frontend/lib/chosen/chosen.min.css')}}">
@endsection
<span class="panel-icon-mobile">menu <i class="fa fa-chevron-down"></i></span>
<nav class="panel-nav">
    <div>
        <div class="panel-nav-acsess">
            <h3>Área do cliente</h3>
            <ul>
                <li>
                    <a href="{{route('accont.home')}}"{!! url()->current() ==  route('accont.home') ? ' class="current_rout"' :  ''!!}>meu
                        cadastro</a></li>
                <li>
                    <a href="{{route('accont.requests')}}"{!! url()->current() ==  route('accont.requests') ? ' class="current_rout"' :  ''!!}>meus
                        pedidos {!! (notification_request(0) > 0 ? '<span class="fl-right padding05-10 radius bg-reddark" style="margin-top: -5px;">'.notification_request(0).'</span>' : '') !!}</a></li>
                <li>
                    <a href="{{route('accont.searchstore')}}"{!! url()->current() ==  route('accont.searchstore') ? ' class="current_rout"' :  ''!!}>procurar
                        loja</a></li>
                <li>
                    <a href="{{route('accont.messages.box',['type'=>'user', 'box' => 'received'])}}"{!! url()->current() ==  route('accont.messages.box',['type'=>'user', 'box' => 'received']) ? ' class="current_rout"' :  ''!!}>mensagens {!! (notification_message_client() >= 1 ? '<span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">'.notification_message_client().'</span>' : '') !!}</a>
                </li>
            </ul>
        </div>
        @can('sallesman')
            <div class="panel-nav-acsess">
                <h3>Área do vendedor</h3>
                <ul>
                    <li>
                        <a href="{{route('accont.salesman.info')}}"{!! url()->current() ==  route('accont.salesman.info') ? ' class="current_rout"' :  ''!!}>informações</a>
                    </li>
                    <li>
                        <a href="{{route('accont.salesman.stores')}}"{!! url()->current() ==  route('accont.salesman.stores') ? ' class="current_rout"' :  ''!!}>minha
                            loja</a></li>
                    <li>
                        <a href="{{route('accont.salesman.products.index')}}"{!! url()->current() ==  route('accont.salesman.products.index') ? ' class="current_rout"' :  ''!!}>meus
                            produtos</a></li>
                    <li>
                        <a href="{{route('accont.salesman.sales')}}"{!! url()->current() ==  route('accont.salesman.sales') ? ' class="current_rout"' :  ''!!}>minhas
                            vendas {!! (notification_sales(0) > 0 ? '<span class="fl-right padding05-10 radius bg-reddark" style="margin-top: -5px;">'.notification_sales(0).'</span>' : '') !!}</a>
                    </li>
                    <li>
                        <a href="{{route('accont.messages.box',['type'=>'store', 'box' => 'received'])}}" {!! url()->current() ==  route('accont.messages.box',['type'=>'store', 'box' => 'received']) ? ' class="current_rout"' :  ''!!}>mensagens {!! (notification_message_salesman() >= 1 ? '<span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">'.notification_message_salesman().'</span>' : '') !!}</a>
                    </li>
                </ul>
            </div>
        @endcan
        @cannot('sallesman')
            <div class="panel-nav-acsess">
                <h3>Área do vendedor</h3>
                <ul>
                    <li>
                        <a href="{{route('accont.salesman.info')}}"{!! url()->current() ==  route('accont.salesman.info') ? ' class="current_rout"' :  ''!!}>Torne-se um vendedor</a></li>
                </ul>
            </div>
        @endcannot
        @can('admin')
            <div class="panel-nav-acsess">
                <h3>Área administrativa</h3>
                <ul>
                    <li>
                        <a href="{{route('accont.report.users')}}"{!! url()->current() ==  route('accont.report.users') ? ' class="current_rout"' :  ''!!}>Usuários</a>
                    </li>
                    <li>
                        <a href="{{route('accont.report.salesman')}}"{!! url()->current() ==  route('accont.report.salesman') ? ' class="current_rout"' :  ''!!}>vendedores {!! (notification_new_sallesman(0) >= 1 ? '<span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">'.notification_new_sallesman(0).'</span>' : '') !!}</a>
                    </li>
                    <li>
                        <a href="{{route('accont.report.products')}}"{!! url()->current() ==  route('accont.report.products') ? ' class="current_rout"' :  ''!!}>produtos</a>
                    </li>
                    {{--<li>--}}
                        {{--<a href="{{route('accont.salesman.products.create')}}"{!! url()->current() ==  route('accont.salesman.products.create') ? ' class="current_rout"' :  ''!!}>cadastrar produto</a>--}}
                    {{--</li>--}}
                    <li>
                        <a href="{{route('accont.categories.index')}}"{!! url()->current() ==  route('accont.categories.index') ? ' class="current_rout"' :  ''!!}>categorias</a>
                    </li>
                    <li>
                        <a href="{{route('accont.banners')}}"{!! url()->current() ==  route('accont.home') ? ' class="current_rout"' :  ''!!}>banners</a>
                    </li>
                    <li>
                        <a href="{{route('accont.report.sales')}}"{!! url()->current() ==  route('accont.report.sales') ? ' class="current_rout"' :  ''!!}>vendas
                            e comissões</a></li>
                    <li>
                        <a href="{{route('accont.report.notifications')}}"{!! url()->current() ==  route('accont.report.notifications') ? ' class="current_rout"' :  ''!!}>notificações {!! (notification_notify_admin(0) >= 1 ? '<span class="fl-right padding05-10 radius bg-blue-gray notify-admin" style="margin-top: -5px;">'.notification_notify_admin(0).'</span>' : '') !!}</a>
                    </li>
                    <li>
                        <a href="{{route('accont.pages')}}"{!! url()->current() ==  route('accont.pages') ? ' class="current_rout"' :  ''!!}>páginas</a>
                    </li>
                </ul>
            </div>
        @endcan
    </div>
</nav>
@section('scripts')
    <script src="{{asset('frontend/lib/chosen/chosen.jquery.min.js')}}"></script>
    <script src='//cloud.tinymce.com/stable/tinymce.min.js?apiKey=fv20eupiztq0ic1rww9p0c6mjoo9djm39coldsa6dpzqbs5a'></script>
    <script src="{{ url('/js/panel.js') }}"></script>
@endsection