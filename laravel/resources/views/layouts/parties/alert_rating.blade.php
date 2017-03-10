<div class="alertbox" id="jq-new-rating">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Avaliar {{ $request->store->name }}</h2>
            <div class="jq-content-rate">

                <p class="fontem-16 txt-center">
                    @if(!isset($request->shopvaluation))
                        Avalie como foi sua experiência com esse vendedor?
                    @else
                        Pedido já avaliado. <b>Obrigado!</b>
                    @endif
                </p>
                <div class="colbox">
                    <div class="colbox-3">
                        <div class="pop-rating">
                            <h3>Prazo de entrega</h3>
                            <div class="rating"
                                 data-rate-value={{isset($request->shopvaluation) ? $request->shopvaluation->note_term : 5}} data-item="delivery"></div>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-rating">
                            <h3>Qualidade do produto</h3>
                            <div class="rating"
                                 data-rate-value={{isset($request->shopvaluation) ? $request->shopvaluation->note_term : 5}} data-item="product"></div>
                        </div>
                    </div>
                    <div class="colbox-3">
                        <div class="pop-rating">
                            <h3>Atendimento</h3>
                            <div class="rating"
                                 data-rate-value={{isset($request->shopvaluation) ? $request->shopvaluation->note_service : 5}} data-item="attendance"></div>
                        </div>
                    </div>
                </div>
                <div class="clear-both"></div>
                @if(!isset($request->shopvaluation))
                    <form class="form-modern pop-form sendRating" action="javascript:void(0)" method="POST">
                        {!! Form::textarea('message', null ,['id' => 'msgS2', 'class' => 'limiter-textarea', 'maxlength' => '500', 'placeholder'=>'Informe aqui sua mensagem', 'rows'=>'7']) !!}
                        <span class="limiter-result" for="msgS2" data-limit="500">500</span>
                        <div class="clear-both"></div>
                        @if(!isset($request->shopvaluation))
                            <div class="txt-center">
                                <button type="submit" class="btn btn-popmartin">enviar</button>
                            </div>
                        @endif
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
@section('script')
    <script src="/public/frontend/lib/rater/rater.min.js"></script>
    <script>
        $(function () {
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
                    'note_store': rating.product,
                    'note_term': rating.delivery,
                    'note_service': rating.attendance,
                    'comment': comment,
                    '_token': '{{ csrf_token() }}'
                };
                if (comment.length < 3) {
                    alertify.error("Comentário precisa ter no mínimo 4 caracteres!");
                } else if (objectLength(rating) < 3) {
                    alertify.error("Você precisa avaliar as 3 característica deste vendedor");
                } else {
                    $.ajax({
                        url: '/accont/request/shop_valuations/' + id,
                        data: data,
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function () {
                            e.find('button[type=submit]').text('processado...').css({background: '#E57373'});
                        },
                        error: function (response) {
//                      alertify.error(response.responseJSON.msg);
                            e.find('button[type=submit]').text('enviar').css({background: '#B71C1C'});
                        },
                        success: function (response) {
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
            max_value: 6,
            step_size: 0.5,
            readonly: readonly
        }
        $(".rating").rate(options);
    </script>
@endsection
