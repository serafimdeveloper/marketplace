<header class="bg-graylightextreme">
    <div class="content shadow-box pop-top-header">
        <div class="pop-logo"></div>
        <div class="navicon-mobile"><i class="fa fa-navicon c-popdark"></i></div>
        <div class="nav-mobile pop-top-nav">
            <div>
                <form class="form pop-search" action="" method="get">
                    <div class="input-group">
                        <input type="text" name="search" placeholder="o que procura?">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="favorite">
                <a class="" href=""><i class="fa fa-heart c-reddark"></i> </a>
            </div>
            <div class="cart">
                <a class="vertical-middle" href="">
                    <i class="fa fa-shopping-bag c-green-avocadodark"></i>
                    <div class="dp-inblock fontem-07 txt-center">
                        <span>COMPRAS</span><br>
                        <span class="c-green fontw-500">R$ 0,00</span>
                    </div>
                </a>
            </div>
            <div class="menu">
                @if (Auth::check())
                      <a class="" href=""><i class="fa fa-user-circle-o c-popdark"></i> 
                        <span class="c-popdark" style="vertical-align: super;">Olá, {{ Auth::user()->name }}</span></a>
                @else
                    <a class="" href=""><i class="fa fa-user-circle-o c-popdark"></i> 
                    <span class="c-popdark" style="vertical-align: super;">faça login ou cadastre-se</span></a>
                @endif
        </div>
        </div>
        <div class="clear-both"></div>
    </div>

    <div class="content">
        <div class="pop-ads owl-carousel">
            <div class="vertical-flex">
                <img src="{{ url('/image/loja/L1V1U1.gif') }}" title="" alt="[]">
                <p>nome da loja <br> <span>frase de impactação</span></p>
                <a href=""></a>
            </div>
            <div class="vertical-flex">
                <img src="{{ url('/image/loja/L1V1U1.gif') }}" title="" alt="[]">
                <p>nome da loja <br> <span>frase de impactação</span></p>
                <a href=""></a>
            </div>
            <div class="vertical-flex">
                <img src="{{ url('/image/loja/L1V1U1.gif') }}" title="" alt="[]">
                <p>nome da loja <br> <span>frase de impactação</span></p>
                <a href=""></a>
            </div>
            <div class="vertical-flex">
                <img src="{{ url('/image/loja/L1V1U1.gif') }}" title="" alt="[]">
                <p>nome da loja <br> <span>frase de impactação</span></p>
                <a href=""></a>
            </div>
            <div class="vertical-flex">
                <img src="{{ url('/image/loja/L1V1U1.gif') }}" title="" alt="[]">
                <p>nome da loja <br> <span>frase de impactação</span></p>
                <a href=""></a>
            </div>
        </div>
        <div class="clear-both"></div>
    </div>

    <div class="pop-nav-main">
        <div class="navicon-mobile c-white" style="float: left;margin-left: 15px;"><i class="fa fa-navicon c-popdark" style="color: #FFF;font-size: 0.875em"></i> <span class="fontem-06" style="vertical-align: middle;">categorias</span></div>
        <div class="clear-both"></div>
        <ul class="nav nav-mobile">
            <li><a href="">menu 1</a></li>
            <li><a href="">menu 2</a></li>
            <li><a href="">menu 3</a></li>
            <li><a href="">menu 4</a></li>
            <li><a href="">menu 5</a></li>
            <li><a href="">menu 6</a></li>
            <li><a href="">menu 7</a></li>
            <li><a href="">menu 8</a></li>
        </ul>
    </div>
</header>
<div class="clear-both"></div>