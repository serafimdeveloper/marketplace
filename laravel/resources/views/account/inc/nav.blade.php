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
                    <a href="{{route('account.home')}}"{!! url()->current() ==  route('account.home') ? ' class="current_rout"' :  ''!!}>meu
                        cadastro</a></li>
                <li>
                    <a href="{{route('account.requests')}}"{!! url()->current() ==  route('account.requests') ? ' class="current_rout"' :  ''!!}>meus
                        pedidos {!! (notification_request(0) > 0 ? '<span class="fl-right padding05-10 radius bg-reddark" style="margin-top: -5px;">'.notification_request(0).'</span>' : '') !!}</a>
                </li>
                <li>
                    <a href="{{route('account.searchstore')}}"{!! url()->current() ==  route('account.searchstore') ? ' class="current_rout"' :  ''!!}>procurar
                        loja</a></li>
                <li>
                    <a href="{{route('account.messages.box',['type'=>'user', 'box' => 'received'])}}"{!! url()->current() ==  route('account.messages.box',['type'=>'user', 'box' => 'received']) ? ' class="current_rout"' :  ''!!}>mensagens {!! (notification_message_client() >= 1 ? '<span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">'.notification_message_client().'</span>' : '') !!}</a>
                </li>
            </ul>
        </div>
        @can('seller')
            <div class="panel-nav-acsess">
                <h3>Área do vendedor</h3>
                <ul>
                    <li>
                        <a href="{{route('account.seller.info')}}"{!! url()->current() ==  route('account.seller.info') ? ' class="current_rout"' :  ''!!}>informações</a>
                    </li>
                    <li>
                        <a href="{{route('account.seller.stores')}}"{!! url()->current() ==  route('account.seller.stores') ? ' class="current_rout"' :  ''!!}>minha loja</a>
                    </li>
                    @if(Auth::user()->seller->store)
                        <li>
                            <a href="{{route('account.seller.products.index')}}"{!! url()->current() ==  route('account.seller.products.index') ? ' class="current_rout"' :  ''!!}>meus
                                produtos</a></li>
                        <li>
                            <a href="{{route('account.seller.sales')}}"{!! url()->current() ==  route('account.seller.sales') ? ' class="current_rout"' :  ''!!}>minhas
                                vendas {!! (notification_sales(0) > 0 ? '<span class="fl-right padding05-10 radius bg-reddark" style="margin-top: -5px;">'.notification_sales(0).'</span>' : '') !!}</a>
                        </li>
                        <li>
                            <a href="{{route('account.messages.box',['type'=>'store', 'box' => 'received'])}}" {!! url()->current() ==  route('account.messages.box',['type'=>'store', 'box' => 'received']) ? ' class="current_rout"' :  ''!!}>mensagens {!! (notification_message_seller() >= 1 ? '<span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">'.notification_message_seller().'</span>' : '') !!}</a>
                        </li>
                    @endif
                </ul>
            </div>
        @endcan
        @cannot('seller')
            <div class="panel-nav-acsess">
                <h3>Área do vendedor</h3>
                <ul>
                    <li>
                        <a href="{{route('account.seller.info')}}"{!! url()->current() ==  route('account.seller.info') ? ' class="current_rout"' :  ''!!}>Torne-se
                            um vendedor</a></li>
                </ul>
            </div>
        @endcannot
        @can('admin')
            <div class="panel-nav-acsess">
                <h3>Área administrativa</h3>
                <ul>
                    <li>
                        <a href="{{route('account.report.users.index')}}"{!! url()->current() ==  route('account.report.users.index') ? ' class="current_rout"' :  ''!!}>Usuários</a>
                    </li>
                    <li>
                        <a href="{{route('account.report.sellers.index')}}"{!! url()->current() ==  route('account.report.sellers.index') ? ' class="current_rout"' :  ''!!}>vendedores {!! (notification_new_sallesman(0) >= 1 ? '<span class="fl-right padding05-10 radius bg-blue-gray" style="margin-top: -5px;">'.notification_new_sallesman(0).'</span>' : '') !!}</a>
                    </li>
                    <li>
                        <a href="{{route('account.report.products.index')}}"{!! url()->current() ==  route('account.report.products.index') ? ' class="current_rout"' :  ''!!}>produtos</a>
                    </li>
                    {{--<li>--}}
                    {{--<a href="{{route('account.seller.products.create')}}"{!! url()->current() ==  route('account.seller.products.create') ? ' class="current_rout"' :  ''!!}>cadastrar produto</a>--}}
                    {{--</li>--}}
                    <li>
                        <a href="{{route('account.report.categories.index')}}"{!! url()->current() ==  route('account.report.categories.index') ? ' class="current_rout"' :  ''!!}>categorias</a>
                    </li>
                    <li>
                        <a href="{{route('account.report.banners')}}"{!! url()->current() ==  route('account.report.banners') ? ' class="current_rout"' :  ''!!}>banners</a>
                    </li>
                    <li>
                        <a href="{{route('account.report.sales')}}"{!! url()->current() ==  route('account.report.sales') ? ' class="current_rout"' :  ''!!}>vendas
                            e comissões</a></li>
                    <li>
                        <a href="{{route('account.report.notifications')}}"{!! url()->current() ==  route('account.report.notifications') ? ' class="current_rout"' :  ''!!}>notificações {!! (notification_notify_admin(0) >= 1 ? '<span class="fl-right padding05-10 radius bg-blue-gray notify-admin" style="margin-top: -5px;">'.notification_notify_admin(0).'</span>' : '') !!}</a>
                    </li>
                    <li>
                        <a href="{{route('account.report.pages')}}"{!! url()->current() ==  route('account.report.pages') ? ' class="current_rout"' :  ''!!}>páginas</a>
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