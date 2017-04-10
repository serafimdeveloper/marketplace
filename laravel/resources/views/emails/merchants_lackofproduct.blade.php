<div style="text-align: justify; font-size: 14px; font-family: Arial,Helvetica,Sans-Serif">
    <a href="{{route('homepage')}}" style="color: #336699; line-height: 50px" target="_blank">

        <!--logo-popmartin-msg.png-->
        <img alt="Pop Martin" src="{{url('imagem/popmartin/logo-popmartin-msg.png')}}" border="0" />    </a>
    <p style="font-size: 16px; font-weight: bold; color: #800000">Olá {{$store->name}},</p>

    <br>

    Produto <a style="font-weight: bold" href="{{ route('pages.product', ['store' => $store->slug, 'category' => $product->category->slug, 'product' => $product->slug]) }}">{{ $product->name }}</a> está em falta para o pedido
    <a style="font-weight: bold" href="{{ url('/accont/salesman/sale/') . $order->id }}">{{ $order->key }}</a>
    <p>
        <br />
        Atenciosamente,<br />
        Equipe Pop Martin.
    </p>
</div>