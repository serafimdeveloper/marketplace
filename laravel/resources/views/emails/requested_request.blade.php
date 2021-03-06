<style type="text/css">
    div{ text-align: justify; font-size: 14px; font-family: Arial,Helvetica,Sans-Serif;  }
    div a{ color: #336699; line-height: 50px; }
    div table{ margin-bottom: 20px; font-size: 14px;}
</style>
<div>
    <a href="{{route('homepage')}}" style="color: #336699; line-height: 50px" target="_blank">
        <img alt="Pop Martin" src="{{url('imagem/popmartin/logo-popmartin-msg.png')}}" border="0" />    </a>
    <p style="font-size: 16px; font-weight: bold; color: #800000">Olá {{$name}},</p>

    <p>
        Você realizou uma compra.<br />
        O vendedor está aguardando a confirmação da instituição financeira para realizar o envio, respeitando o prazo de envio definido para cada produto.
    </p>

    <p><a href="{{route('account.request_info', [$request->id])}}">Envie uma mensagem para o vendedor</a></p>

    <h3>Detalhes do pedido</h3>
    <table style="margin-bottom: 20px; font-size: 14px">
        <tbody>
        <tr>
            <td style="font-weight: bold">Número do pedido:</td>
            <td>{{$request->key}}</td>
        </tr>
        <tr>
            <td style="font-weight: bold">Realizado em:</td>
            <td>{{$request->created_at->format('d/m/Y H:i:s')}}</td>
        </tr>
        <tr>
            <td style="font-weight: bold">Forma de frete:</td>
            <td>{{$request->freight->name}}</td>
        </tr>
        </tbody>
    </table>
    {{$store->name}}
    <table style="font-size: 14px">
        <thead>
        <tr>
            <th class="t-medium" style="width: 100px;"></th>
            <th>Produto</th>
            <th class="t-small">Quantidade</th>
            <th class="t-medium">Valor unitário</th>
            <th class="t-small">Valor total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <td class="txt-center" style="max-width: 100px;"><img src="{{ url('imagem/produto/' . $product->galleries[0]->image.'?w=40') }}"></td>
                <td><a href="{{route('pages.product',[$store->slug, $product->category->slug, $product->slug])}}" class="fontem-12" target="_blank">{{ $product->name }}</a></td>
                <td>{{ $product->pivot->quantity }}</td>
                <td><span class="fontem-12">{{ real($product->pivot->unit_price)}}</span></td>
                <td class="bold"><span class="fontem-12">{{ real($product->pivot->amount) }}</span></td>
            </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td class="bold" colspan="4" style="text-align: right;"><span class="fontem-18 fontw-800">{{real(amount_products($request->products))}}</span></td>
        </tr>
        <tr>
            <td>Valor do envio:</td>
            <td class="bold" colspan="4" style="text-align: right;">{{real($request->freight_price)}}</td>
        </tr>
        <tr>
            <td>Valor total do pedido:</td>
            <td class="bold" colspan="4" style="text-align: right;">{{real($request->amount)}}</td>
        </tr>
        </tbody>
    </table>
    <br />
    <p>
        Atenciosamente,<br />
        Equipe Pop Martin.
    </p>
</div>