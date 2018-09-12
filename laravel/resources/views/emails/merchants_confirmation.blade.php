<div style="text-align: justify; font-size: 14px; font-family: Arial,Helvetica,Sans-Serif">
    <a href="{{route('homepage')}}" style="color: #336699; line-height: 50px" target="_blank">

        <!--logo-popmartin-msg.png-->
        <img alt="Pop Martin" src="{{url('imagem/popmartin/logo-popmartin-msg.png')}}" border="0" />    </a>
    <p style="font-size: 16px; font-weight: bold; color: #800000">Olá {{$request->store->name}},</p>
    <p>
        Parabéns! Confirmamos o pagamento do pedido {{$request->key}}. Você já pode enviar seu produto.<br>
        Não se esqueça de informar o código de rastreio (AR) para o seu cliente assim que você enviar o produto.
    </p>
    <p><a href="{{route('account.seller.sale_info', [$request->id])}}" target="_blank">Inserir código de rastreio</a></p>
    <p>
        Não deixe de cumprir o prazo de entrega informado na sua loja.<br>
        Caso queira falar com o comprador agora, clique no link abaixo:
    </p>
    <p><a href="{{route('account.seller.sale_info', [$request->id])}}">Envie uma mensagem para o comprador</a></p>
    <p>Nunca deixe de seguir o código de defesa do consumidor. Fizemos um pequeno resumo para você ficar atento aos seus direitos e obrigações.</p>

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
    {{$request->store->name}}
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
        @foreach($request->products as $product)
            <tr>
                <td class="txt-center" style="max-width: 100px;"><img src="{{ url('imagem/produto/' . $product->galleries[0]->image.'?w=40') }}"></td>
                <td><a href="{{route('pages.product',[$request->store->slug, $product->category->slug, $product->slug])}}" class="fontem-12" target="_blank">{{ $product->name }}</a></td>
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

    <h3>Endereço de entrega</h3>
    <p>
        <span>{{ $request->user->name }} {{ $request->user->last_name }}</span><br>
        <span> {{'CEP: '.$request->address->zip_code.' - '.$request->address->public_place.', '.$request->address->number
        .(($request->address->complements) ? ' ('.$request->address->complements.')' : '')
        .', '.$request->address->neighborhood.', '.$request->address->city.' - '.$request->address->state}}</span><br>
    </p>
    <p>
        <br />
        Atenciosamente,<br />
        Equipe Pop Martin.
    </p>
</div>