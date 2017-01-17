<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>PopMartin</title>

    <!-- Bootstrap -->
    {{--<link href="/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="/frontend/css/bootstrap.css" rel="stylesheet">
    <link href="/frontend/lib/owlcarousel/owl.carousel.min.css" rel="stylesheet">
    <link href="/frontend/lib/owlcarousel/theme/owl.theme.default.min.css" rel="stylesheet">
    <link href="/css/popmartin.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<main class="container">
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
                    <a class="" href=""><i class="fa fa-user-circle-o c-popdark"></i> <span class="c-popdark"
                                                                                            style="vertical-align: super;">faça login ou cadastre-se</span></a>
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