<div class="alertbox" id="jq-new-rating">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Avaliar {{ $request->store->name }}</h2>
            <div class="jq-content-rate">

                <p class="fontem-16 txt-center">
                    @if(!$request->shopvaluation)
                        Avalie como foi sua experiência com esse vendedor?
                    @else
                        Pedido já avaliado. <b>Obrigado!</b>
                    @endif
                </p>
                @if(!$request->shopvaluation)
                    <div class="form-modern">
                        <div class="checkbox-container padding10" style="position:relative;">
                            <div class="checkboxies txt-center jq-check-aval">
                                <label class="radio" style="border: none;">
                                    {{--<span><span class="fa {{ ($user->genre === 'M') ? 'fa-check-circle-o c-green':''}}"></span> masculino</span>--}}
                                    <span><span class="fa fa-circle-o"></span> produto recebido</span>
                                    {!! Form::radio('aval','recebido') !!}
                                </label>
                                <label class="radio" style="border: none;">
                                    <span><span class="fa fa-circle-o"></span> produto devolvido</span>
                                    {!! Form::radio('aval','devolvido', ['class' => 'jq-avalSelect']) !!}
                                </label>
                            </div>
                            <span class="alert{{ $errors->has('genre') ? '' : ' hidden' }}">{{ $errors->first('genre') }}</span>
                        </div>
                    </div>
                    @else
                    <p class="txt-center">Produto {{ $request->shopvaluation->request_status }}</p>
                @endif
                <div class="form-modern jq-aval-devolvido" style="margin-top: -15px;">
                    <span>Motivo da devolução:</span>
                    <select name="return_reason">
                        <option value="produto diferente do comprado">produto diferente do comprado</option>
                        <option value="produto com defeito">produto com defeito</option>
                        <option value="não gostei do produto">não gostei do produto</option>
                    </select>
                </div>
                {{--{{ dd($request->shopvaluation) }}--}}
                <br>
                <div class="colbox">
                    <div class="colbox-2">
                        <div class="pop-rating">
                            <h3>Qualidade do(s) produto(s)</h3>
                            <div class="rating"
                                 data-rate-value={{$request->shopvaluation ? $request->shopvaluation->note_products : 5}} data-item="product"></div>
                        </div>
                    </div>
                    <div class="colbox-2">
                        <div class="pop-rating">
                            <h3>Atendimento</h3>
                            <div class="rating"
                                 data-rate-value={{$request->shopvaluation ? $request->shopvaluation->note_attendance : 5}} data-item="attendance"></div>
                        </div>
                    </div>
                </div>
                <div class="clear-both"></div>
                @if(!$request->shopvaluation)
                    <form class="form-modern pop-form sendRating" action="javascript:void(0)" method="POST">
                        {!! Form::textarea('message', null ,['id' => 'msgS2', 'class' => 'limiter-textarea', 'maxlength' => '500', 'placeholder'=>'Informe aqui sua mensagem', 'rows'=>'7']) !!}
                        <span class="limiter-result" for="msgS2" data-limit="500">500</span>
                        <div class="clear-both"></div>
                        <div class="txt-center">
                            <button type="submit" class="btn btn-popmartin">enviar</button>
                        </div>
                    </form>
                @else
                    <div class="content">
                        <p>Comentário</p>
                        <div class="padding10-20 bg-white">
                            {{ $request->shopvaluation->comment }}
                        </div>
                    </div>
                    <div class="txt-center">
                        <span class="btn btn-popmartin jq-close-alertbox">fechar</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/lib/rater/rater.min.js') }}"></script>
<script>
    $(function () {
        $('.jq-avalSelect').click(function () {
            $('.')
        });


        var rating = [];
        $(".rating").rate();
        $(".rating").on("change", function (ev, data) {
            var e = $(this)
            rating[e.data('item')] = data.to;
        });

        $('.sendRating').on('submit', function () {
            var e = $(this);
            var comment = e.find('textarea').val();
            var id = '{{$request->id}}';
            var data = {
                'user_id': '{{ $user->id }}',
                'store_id': '{{ $request->store->id }}',
                'note_products': rating['product'],
                'note_attendance': rating['attendance'],
                'request_status': statusRating(),
                'comment': comment,
                '_token': '{{ csrf_token() }}'
            };
            console.log(data);
            if (!statusRating()) {
                backBtnForm(e);
                alertify.error("Marque 'produto recebido' se ocorreu tudo certo com sua compra!");
            } else if (objectLength(rating) < 2) {
                backBtnForm(e);
                alertify.error("Você precisa avaliar as 2 característica deste vendedor");
            } else if (comment.length < 3) {
                backBtnForm(e);
                alertify.error("Comentário precisa ter no mínimo 4 caracteres!");
            } else {
                $.ajax({
                    url: '/accont/request/shop_valuations/' + id,
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function () {
                        e.find('button[type=submit]').text('enviando...').css({background: '#EB9292'});
                    },
                    error: function (response) {
//                      alertify.error(response.responseJSON.msg);
                        backBtnForm(e);
                    },
                    success: function (response) {
                        backBtnForm(e)
                        e.parents('.jq-content-rate').html('<div class="txt-center fontem-22 padding30"><p><i class="fa fa-check-circle c-green fontem-30"></i> </p>' +
                            'Sua avaliaçõa foi contabilizada com sucesso!<br>' +
                            'Obrigado pela sua colaboração.<br><br><p class="fontem-05"><a href="" class="btn btn-popmartin">fechar</a></p></div>');
                    }
                });
            }
            return false;
        });
    });
    var readonly = '{{isset($request->shopvaluation) ? true : false}}';
    var options = {
        max_value: 5,
        step_size: 0.5,
        readonly: readonly
    }
    $(".rating").rate(options);

    function backBtnForm(e) {
        e.find('button[type=submit]').text('enviar').css({background: '#B71C1C'});
    }
    function statusRating() {
        var status = false;
        $(document).ready(function () {
            $('.jq-check-aval').find("input").each(function (i) {
                if ($(this).is(":checked")) {
                    status = $(this).val();
                }
            });
        });

        return status
    }
</script>
