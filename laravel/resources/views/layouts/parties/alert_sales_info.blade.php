<div class="alertbox" id="jq-info-sale">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Pedido: #{{$result->key}}</h2>
            <table id="jq-search-table-result" class="table table-action">
                <thead>
                <tr>
                    <th class="t-medium">Código</th>
                    <th>Produto</th>
                    <th class="t-medium">Valor unítário</th>
                    <th class="t-small">Quantidade</th>
                    <th class="t-medium">Sub-total</th>
                </tr>
                </thead>

                <tbody>
                @foreach($result->products as $product)
                    <tr>
                        <td>#{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{real($product->pivot->unit_price)}}</td>
                        <td>{{$product->pivot->quantity}}</td>
                        <td>{{real($product->pivot->amount)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pop-user-info">
                <div class="colbox">
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>Cliente</p>
                            <span>{{$result->user->name.' '.$result->user->last_name}}</span>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>Data do pedido</p>
                            <span>{{$result->created_at->format('d/m/Y H:i:s')}}</span>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>Forma de pagamento</p>
                            <span>Moip</span>
                        </div>
                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Tipo de frete</p>
                            <span>{{$result->freight->name}}</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Valor frete</p>
                            <span>{{real($result->freight_price)}}</span>
                        </div>
                    </div>
                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Valor Total</p>
                            <span>{{real($result->amount)}}</span>
                        </div>
                    </div>

                    <div class="colbox-4">
                        <div class="pop-info-user">
                            <p>Comissão</p>
                            <span>{{($result->commission_amount) ? real($result->commission_amount) : '-'}}</span>
                        </div>
                    </div>
                </div>
                <div class="colbox">

                </div>
                <div class="colbox">
                    <div class="colbox-full">
                        <div class="pop-info-user">
                            <p>Endereço de entrega</p>
                            @if($result->address['receiver'])
                                <span>{{$result->address['receiver']['public_place'].' | '.$result->address['receiver']['number'] }}
                                    {{ ($result->address['receiver']['complements']) ? ' ('.$result->address['receiver']['complements'].') |' : '| ' }}
                                    {{ $result->address['receiver']['neighborhood'].' | '.$result->address['receiver']['city'].' | '.$result->address['receiver']['state'].' | ' }}
                                    {{ $result->address['receiver']['zip_code'] }}</span>
                            @else
                                <span>Endereço de entrega não identificado!</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="colbox">
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>Status</p>
                            <span>{{$result->requeststatus->description}}</span>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>Data de envio</p>
                            <span>{{($result->send_date) ? $result->send_date->format('d/m/Y H:i:s') : 'ainda não enviado'}}</span>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-info-user">
                            <p>Código de Rastreamento</p>
                            <span>{{($result->tracking_code) ? $result->tracking_code : 'não foi enviado'}}</span>
                        </div>
                    </div>
                </div>
                <div class="clear-both"></div>
            </div>
        </div>
    </div>
</div>
</div>