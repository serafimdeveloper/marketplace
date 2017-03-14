<div id="MoipWidget"
     data-token="{{ $tokenmoip }}"
     callback-method-success="moipSuccess"
     callback-method-error="moipError"></div>
<iframe name="billetMoip" class="dp-none" id="billetMoip" width="600" height="400" src=""></iframe>
@section('script')
    <script
            type='text/javascript'
            src='https://desenvolvedor.moip.com.br/sandbox/transparente/MoipWidget-v2.js'
            charset='ISO-8859-1'>
    </script>
    <script type="text/javascript">
        var moipSuccess = function(response){
            $.post('/carrinho/checkout/updateorder', response, function(){
                loaderAjaxScreen(true, 'finalizando...');
                if(response.Codigo === 0){
                    $('#billetMoip').attr('src', response.url);
                    MessageScreen('default', ' ' +
                        'Essa compra está sendo efetuada somente nesta loja. Caso haja produtos de outra loja em seu carrinho, não esqueça de finaliza-las também<br>' +
                        '<a href="/carrinho" class="btn btn-small btn-popmartin-trans">carrinho de compras</a> ' +
                        '<a href=""> <a class="btn btn-small btn-popmartin" href="https://desenvolvedor.moip.com.br/sandbox/Instrucao.do?token={{ $tokenmoip }}" target="_blank" onClick="PrintIframe(billetMoip);return false;">Imprimir boleto</a>');
                }else{
                    window.location.replace("/carrinho/checkout/status/success");
                }
            });

        };

        var moipError = function(response) {
            alertify.error(response.Mensagem);
        };

        payBillet = function() {
            loaderAjaxScreen(true, 'processando...');
            var settings = {
                "Forma": "BoletoBancario"
            }
            MoipWidget(settings);
        }
        payCredCart = function() {
            var settings = {
                "Forma": "CartaoCredito",
                "Instituicao": "Visa",
                "Parcelas": "1",
                "CartaoCredito": {
                    "Cofre": "0b2118bc-fdca-4a57-9886-366326a8a647",
                    "CodigoSeguranca": "123"
                }
            }
            MoipWidget(settings);
        }
    </script>
@endsection