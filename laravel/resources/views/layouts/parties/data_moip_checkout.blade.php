<div id="MoipWidget"
     data-token="{{ $tokenmoip }}"
     callback-method-success="moipSuccess"
     callback-method-error="moipError"></div>
<iframe name="billetMoip" class="dp-none" id="billetMoip" width="600" height="400" src=""></iframe>
<form id="formCredences" class="form-modern pop-form dp-none" style="margin-top: -30px;">
    <label>
        <span>Nome do titular do cartão:</span>
        <input type="text" name="Nome" value="{{ $order->user->name }} {{ $order->user->last_name }}"
               data-required="minlength" data-minlength="3">
        <span class="alert hidden"></span>
    </label>
    <input type="hidden" name="Telefone" value="{{ $order->user->phone }}">
    <div class="colbox">
        <div class="colbox-3">
            <label>
                <span>CPF:</span>
                <input type="text" name="Identidade" value="{{ $order->user->cpf }}" data-required="minlength"
                       data-minlength="11">
                <span class="alert hidden"></span>
            </label>
        </div>
        <div class="colbox-3">
            <label>
                <span>Data de nascimento</span>
                <input type="date" pattern="format:DD/MM/YYYY" name="DataNascimento" value="{{ $order->user->birth }}"
                       data-required="notnull">
                <span class="alert hidden"></span>
            </label>
        </div>
        <div class="colbox-3">
            <label>
                <span>Parcelas</span>
                <select name="Parcelas" id="plots">
                    <option selected disabled><i class="fa fa-spin fa-spinner"></i></option>
                </select>
            </label>
        </div>
    </div>
    <div class="clear-both"></div>
    <div class="checkbox-container padding10" style="position:relative;">
        <span>Instituição:</span>
        <div class="checkboxies txt-center">
            <label class="radio txt-center" style="border: none;">
                <span><i class="flag flag-visa"></i> <br> <span class="fa fa-circle-o"></span></span>
                {!! Form::radio('Instituicao','Visa') !!}
            </label>
            <label class="radio txt-center" style="border: none;">
                <span><i class="flag flag-mastercard"></i><br><span class="fa fa-circle-o"></span></span>
                {!! Form::radio('Instituicao','MasterCard') !!}
            </label>
            <label class="radio txt-center" style="border: none;">
                <span><i class="flag flag-hipercard"></i><br><span class="fa fa-circle-o"></span> </span>
                {!! Form::radio('Instituicao','Hipercard') !!}
            </label>
            <label class="radio txt-center" style="border: none;">
                <span><i class="flag flag-hiper"></i> <br><span class="fa fa-circle-o"></span> </span>
                {!! Form::radio('Instituicao','Hiper') !!}
            </label>
            <label class="radio txt-center" style="border: none;">
                <span><i class="flag flag-dinersclub"></i> <br><span class="fa fa-circle-o"></span> </span>
                {!! Form::radio('Instituicao','Dinners Club') !!}
            </label>
            <label class="radio txt-center" style="border: none;">
                <span><i class="flag flag-americanexpress"></i> <br><span class="fa fa-circle-o"></span> </span>
                {!! Form::radio('Instituicao','American Express') !!}
            </label>
            <label class="radio txt-center" style="border: none;">
                <span><i class="flag flag-elo"></i> <br><span class="fa fa-circle-o"></span> </span>
                {!! Form::radio('Instituicao','Elo') !!}
            </label>
        </div>
        <div class="credcard-info dp-none">
            <div class="colbox">
                <div class="colbox-3">
                    <label>
                        <span>Número do cartão</span>
                        <input type="text" name="Numero" value="" data-required="minlength" data-minlength="13">
                        <span class="alert hidden"></span>
                    </label>
                </div>
                <div class="colbox-3">
                    <label>
                        <span>Código CVV</span>
                        <input type="text" name="CodigoSeguranca" value="" data-required="minlength" data-minlength="3">
                        <span class="alert hidden"></span>
                    </label>
                </div>
                <div class="colbox-3">
                    <label>
                        <span>Data de expiração</span><br>
                        <select name="month" style="display: inline-block;width: 100px;">
                            <option disabled selected>Mês</option>
                            @for($i = 1; $i<13; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <select name="year" style="display: inline-block;width: 100px;">
                            <option disabled selected>Ano</option>
                            @for($i = date("y"); $i <= (date("y") + 20); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </label>
                </div>
            </div>
            <div class="clear-both"></div>
        </div>
        <br>
        <div class="txt-center">
            <button type="submit" class="btn btn-popmartin">Confirmar pagamento</button>
        </div>
    </div>
</form>
<div id="payBoletoMessage" class="txt-center dp-none padding20 fontem-14" style="margin-top: -30px;">
    Essa compra está sendo efetuada somente nesta loja. Caso haja produtos de outra loja em seu carrinho, não esqueça de
    finaliza-las também<br>
    {{--<a href="/carrinho" class="btn btn-small btn-popmartin-trans">carrinho de compras</a>--}}
    <a class="btn btn-small btn-popmartin" href="{{env('MOIP_URL')}}/Instrucao.do?token={{ $tokenmoip }}" target="_blank">Imprimir boleto</a>
</div>
@section('scripts_int')
    <script
            type='text/javascript'
            src='{{env('MOIP_URL')}}/transparente/MoipWidget-v2.js'
            charset='ISO-8859-1'>
    </script>
    <script type="text/javascript">
        var InfoCards = [];
        $(document).on("submit", "#formCredences", function () {
            var serialize = $(this).serializeArray();
            $.each(serialize, function (key, value) {
                if (value.name == 'DataNascimento') {
                    var data = value.value;
                    var dataBr = data.split("-");
                    var myData = dataBr[2] + '/' + dataBr[1] + '/' + dataBr[0];
                    value.value = myData;
                } else if (value.name == 'Telefone') {
                    value.value = value.value.replace(" ", "");
                }

                InfoCards[value.name] = value.value;
            });

            console.log(InfoCards);

            payCredCart();
            return false;
        });
        alertify.genericDialog || alertify.dialog('genericDialog', function () {
            return {
                main: function (content) {
                    this.setContent(content);
                },
                setup: function () {
                    return {
                        focus: {
                            element: function () {
                                return this.elements.body.querySelector(this.get('selector'));
                            },
                            select: true
                        },
                        options: {
                            basic: true,
                            maximizable: false,
                            resizable: false,
                            padding: false
                        }
                    };
                },
                settings: {
                    selector: undefined
                }
            };
        });

        var moipSuccess = function (response) {
            loaderAjaxScreen(true, 'finalizando...');
            var token = "{!! csrf_token() !!}";
            var order = "{{ $order_key }}";
            var data = {
                "response": response,
                "order": order,
                "_token": token
            }, type, trg, msg, url;
            $.post('/carrinho/checkout/updateorder', data, function () {
                if (response.Status == undefined) {
                    type = 'boleto';
                    trg = 'accept';
                    msg = 'Compra iniciada. Estamos aguardando o pagamento do boleto';
                    url = response.url;
                }else{
                    if (response.Status == 'Autorizado') {
                        type = 'credcard';
                        trg = 'accept';
                        msg = 'Compra efetuada com sucesso. Agradecemos sua preferência';
                    } else if (response.Status == 'EmAnalise') {
                        type = 'credcard';
                        trg = 'notice';
                        msg = 'Compra em análise! Aguardando resposta de pagamento da instituição do cartão';
                        url = '{{ route('accont.request_info', ['id' => $order->id]) }}';
                    } else if (response.Status == 'Iniciado') {
                        type = 'credcard';
                        trg = 'accept';
                        msg = 'Compra iniciada! Aguardando conclusão de pagamento da instituição do cartão';
                        url = '{{ route('accont.request_info', ['id' => $order->id]) }}';
                    } else {
                        type = 'credcard';
                        trg = 'error';
                        msg = 'Compra cancelada!';
                    }
                }
                location.replace('/carrinho?type='+type+'&trg='+trg+'&msg='+msg+'&redirectURL='+url);
            });
        };

        var moipError = function (response) {
            alertify.error(response.Mensagem);
            $("#formCredences").find('button').html('Confirmar pagamento').css({background: '#B40004'});
        };

        payBillet = function () {
            loaderAjaxScreen(true, 'processando...');
            var settings = {
                "Forma": "BoletoBancario"
            }
            MoipWidget(settings);
        }
        payCredCart = function () {
            console.log(InfoCards);
            var settings = {
                "Forma": "CartaoCredito",
                "Instituicao": InfoCards['Instituicao'],
                "Parcelas": InfoCards['Parcelas'],
                "CartaoCredito": {
                    "Numero": InfoCards['Numero'],
                    "Expiracao": InfoCards['month'] + "/" + InfoCards['year'],
                    "CodigoSeguranca": InfoCards['CodigoSeguranca'],
                    "Portador": {
                        "Nome": InfoCards['Nome'],
                        "DataNascimento": InfoCards['DataNascimento'],
                        "Telefone": InfoCards['Telefone'],
                        "Identidade": InfoCards['Identidade']
                    }
                }
            }
            MoipWidget(settings);
        }

        calculatePlots = function () {
            var settings = {
                cofre: "",
                instituicao: "Visa",
                callback: "returnCalculatePlots"
            };

            MoipUtil.calcularParcela(settings);
        }
        returnCalculatePlots = function (data) {
            console.log(data);
            var options = '';
            $.each(data.parcelas, function (key, value) {
                options += '<option value="' + value.quantidade + '">' + value.quantidade + 'x R$ ' + value.valor + '</option>';
            });

            $('#plots').html(options);
        };

        addCredencies = function () {
            $("#formCredences").show();
            calculatePlots();
            alertify.genericDialog($('#formCredences')[0]);
        }

        $("#formCredences").find('.checkboxies').find('input').on('click', function () {
            $('.credcard-info').slideDown();
        });

        function setMessage(trigger, msg) {
            var fa = trigger == 'accept' ? 'fa-check' : (trigger == 'error' ? 'fa-times' : 'fa-warning');
            $("#formCredences").html('<div class="txt-center">' +
                '<p class="trigger ' + trigger + '"><i class="fa ' + fa + '"></i> ' + msg + '</p>' +
                    @if(Session::has('cart'))
                        '<p class="fontem-14">Você possui mais produtos no carrinho. Continue comprando!<br> <a href="{{ route('pages.cart') }}" class="btn btn-small btn-popmartin">Voltar para o carrinho</a></p>' +
                    @endif
                        '</div>');
        }
    </script>
@endsection