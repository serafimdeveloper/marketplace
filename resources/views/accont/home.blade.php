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
            <div class="pop-top-nav">
                <div class="search">
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
                    <a class="" href=""><i class="fa fa-shopping-bag c-green-avocadodark"></i> </a>
                </div>
                <div class="menu">
                    <a class="" href=""><i class="fa fa-user-circle-o c-popdark"></i> <span class="c-popdark"
                                                                                            style="vertical-align: super;">faça login ou cadastre-se</span></a>
                </div>
            </div>
            <div class="clear-both"></div>
        </div>

        <div class="content" style="padding-top: 0; padding-bottom: 0;">
            <div class="pop-logo"></div>
            <div class="pop-ads colbox">
                <div class="colbox-5">
                    <img src="{{ url('/image/loja/L1V1U1.gif') }}" title="" alt="[]">
                    <p>nome da loja <br> <span>frase de impactação</span></p>
                </div>
                <div class="colbox-5">banner 1</div>
                <div class="colbox-5">banner 1</div>
                <div class="colbox-5">banner 1</div>
                <div class="colbox-5">banner 1</div>
            </div>
            <div class="clear-both"></div>
        </div>

        <div class="pop-nav-main">
            <ul class="nav">
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
</main>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/frontend/js/bootstrap.js"></script>
</body>
</html>