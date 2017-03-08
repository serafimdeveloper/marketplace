@if (Request::segment(1) == 'accont')
    <header class="pop-header" style="background: none; height: 43px;">
        <div class="pop-top-header panel-top-header">
            @else
                <header class="pop-header">
                <div class="pop-top-header">
                    @endif
                    <div class="content">
                        <div class="pop-logo"><a href="/" title="página inicial"></a></div>
                        <div class="navicon-mobile"><i class="fa fa-navicon c-popdark"></i></div>
                        <div class="nav-mobile pop-top-nav">
                            <div class="header-search">
                                <form class="form pop-search" action="/pesquisa" method="get">
                                    <div class="input-group">
                                        <input type="text" name="search" placeholder="o que procura?">
                                        <button type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="header-menu">
                                <div class="facebook">
                                    <a class="" href=""><i
                                                class="fa fa-facebook-official c-facebook vertical-middle"></i> </a>
                                </div>
                                <div class="favorite">
                                    <a class="" href="/favoritos"><i class="fa fa-heart c-reddark vertical-middle"></i> </a>
                                </div>
                                <div class="cart">
                                    <a class="vertical-middle" href="/carrinho">
                                        <i class="fa fa-shopping-cart c-green-avocadodark vertical-middle"></i>
                                        <div class="dp-inblock fontem-07 txt-center" id="amount-cart">
                                            <span class="c-green fontw-500">R$ {{number_format(Session::has('cart') ? Session::get('cart')->amount : 0.00,2,',','.')}}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="menu">
                                    @if (Auth::check())
                                        <a class="" href="javascript:void(0)"><i
                                                    class="fa fa-user-circle-o c-popdark vertical-middle"></i>
                                            <span class="c-popdark">Olá, {{ Auth::user()->name }} <i
                                                        class="fa fa-caret-down vertical-middle"></i></span></a>
                                        <div class="menu-hidden">
                                            <ul>
                                                <li><a href="/accont">minha conta</a>
                                                </li>
                                                <li><a href="/logout">sair</a>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <a href="/login" title="entrar">
                                            <span class="c-popdark"
                                                  tyle="vertical-align: super;">registrar/entrar</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                </div>
                @if (Request::segment(1) != 'accont')
                    <div class="content-ads">
                        <div class="pop-ads owl-carousel">
                            @for($i = 0; $i < 5; $i++)
                            <div class="vertical-flex">
                                <img src="{{ url('imagem/popmartin/img-exemple.jpg?w=100&h=100&fit=crop') }}" title="" alt="[]">
                                <p>nome da loja <br> <span>frase de impactação</span></p>
                                <a href=""></a>
                            </div>
                            @endfor
                        </div>
                        <div class="clear-both"></div>
                    </div>

                    <div class="pop-nav-main">
                        <div class="pop-nav-content">
                            <div class="navicon-mobile c-white" style="float: left;margin-left: 15px;"><i
                                        class="fa fa-navicon c-popdark vertical-middle" style="color: #FFF;font-size: 0.875em"></i> <span
                                        class="fontem-06" style="vertical-align: middle;">categorias</span></div>
                            <div class="clear-both"></div>
                            <ul class="nav nav-mobile">
                                @for($i=1;$i<9;$i++)
                                    <li><a href="">menu {{$i}}</a></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
    @endif
</header>
<div class="clear-both"></div>