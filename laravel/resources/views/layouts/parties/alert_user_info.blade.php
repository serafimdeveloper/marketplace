<div class="alertbox" id="jq-info-user">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Dados do Usuário completo</h2>
            <div class="pop-user-info">
                <div class="pop-user-info-action">
                    <a class="btn btn-small btn-popmartin fl-right jq-remove-user" data-token="{{ csrf_token() }}"
                       data-id="{{ $result->id }}"><i class="fa fa-trash"></i> remover usuário</a>
                </div>
                <div class="clear-both"></div>

                <div class="accordion">
                    <div class="accordion-box">
                        <div class="accordion-header"><span class="c-pop fontw-500">Dados do usuário:</span> <span
                                    class="fa fa-chevron-right"></span></div>
                        <div class="accordion-content">
                            <div class="colbox">
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>Nome</p>
                                        <span>{{$result->name.' '.$result->last_name}}</span>
                                    </div>
                                </div>
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>Tipo</p>
                                        <span>{{$type}}</span>
                                        {{--<span>consumidor</span>--}}
                                    </div>
                                </div>
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>CPF</p>
                                        <span>{{isset($result->cpf) ? $result->cpf : 'não informado'}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                            <div class="colbox">
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Gênero</p>
                                        <span>{{($result->genre === 'M') ? 'Masculino' : 'Feminino'}}</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Nascimento</p>
                                        <span>{{isset($result->birth) ? $result->birth->format('d/m/Y') : 'não informado'}}</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Data de cadastro</p>
                                        <span>{{$result->created_at->format('d/m/Y')}}</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Último acesso</p>
                                        <span>{{$result->last_access->format('d/m/Y H:i:s')}}</span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Contato</p>
                                        <span class="dp-inblock">{{$result->email}} | </span>
                                        <span class="dp-inblock">{{$result->phone}}  </span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Endereço</p>
                                        @if($address = $result->addresses->where('master',1)->first())
                                            <span>{{ $address->public_place.' | '.$address->number }}
                                                {{ ($address->complements) ? ' ('.$address->complements.') |' : '| ' }}
                                                {{ $address->neighborhood.' | '.$address->city.' | '.$address->state.' | ' }}
                                                {{ $address->zip_code }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{--<div class="colbox">--}}
                            {{--<div class="colbox-4">--}}
                            {{--<div class="pop-info-user">--}}
                            {{--<p>Status</p>--}}
                            {{--<form class="form-modern" action="" method="POST">--}}
                            {{--<div class="checkbox-container">--}}
                            {{--<div class="checkboxies">--}}
                            {{--<label class="checkbox" style="border: none;padding: 0;">--}}
                            {{--<span><i class="fa fa-square-o"></i> ativo</span>--}}
                            {{--{!! Form::checkbox('status', isset($result->active) ? 1 : 0) !!}--}}
                            {{--</label>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</form>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="clear-both"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>