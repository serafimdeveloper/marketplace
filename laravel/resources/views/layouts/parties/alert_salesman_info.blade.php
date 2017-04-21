<div class="alertbox" id="jq-info-salesman">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Dados do Vendendor Completo</h2>
            <div class="pop-user-info">
                <div class="pop-user-info-action">
                    <a class="btn btn-small btn-popmartin fl-right btn-delete-salesman" data-token="{{csrf_token()}}" data-id="{{$result->id}}" style="margin-left: 10px;"><i class="fa fa-trash"></i> remover usuário</a>
                    <a class="btn btn-small btn-popmartin fl-right btn-unlock-salesman" data-id="{{$result->id}}">{!! ($result->active) ? '<i class="fa fa-unlock"></i> bloquear vendedor' : '<i class="fa fa-unlock"></i> desbloquear vendedor'!!} </a>
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
                                        <span>{{$result->user->name.' '.$result->user->last_name}}</span>
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
                                        <span>{{isset($result->user->cpf) ? $result->user->cpf : 'não informado'}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                            <div class="colbox">
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Gênero</p>
                                        <span>{{($result->user->genre === 'M') ? 'Masculino' : 'Feminino'}}</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Nascimento</p>
                                        <span>{{isset($result->user->birth) ? $result->user->birth->format('d/m/Y') : 'não informado'}}</span>
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
                                        <span>{{isset($result->user->last_access) ? $result->user->last_access->format('d/m/Y H:i:s') : 'sem data'}}</span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Contato</p>
                                        <span class="dp-inblock">{{$result->user->email}} | </span>
                                        <span class="dp-inblock">{{$result->user->phone}} | </span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Endereço</p>
                                        @if($address = $result->user->addresses->where('master',1)->first())
                                            <span>{{ $address->public_place.' | '.$address->number }}
                                                {{ ($address->complements) ? ' ('.$address->complements.') |' : '| ' }}
                                                {{ $address->neighborhood.' | '.$address->city.' | '.$address->state.' | ' }}
                                                {{ $address->zip_code }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="colbox">
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Moip</p>
                                        <span>{{$result->moip}}</span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Documento com foto</p>
                                        <span><a href="{{url('imagem/vendedor/'.$result->photo_document)}}" class="btn btn-smallextreme btn-popmartin"
                                                 target="_blank">ver documento</a></span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Comprovante de residência</p>
                                        <span><a href="{{url('imagem/vendedor/'.$result->proof_adress)}}" class="btn btn-smallextreme btn-popmartin"
                                                 target="_blank">ver documento</a></span>
                                    </div>
                                </div>
                                <div class="colbox-4">
                                    <div class="pop-info-user">
                                        <p>Comissão (%)</p>
                                         {!! Form::open(['route' =>['accont.report.salesman.update', $result->id],'id'=>'form-commission', 'method' => 'PUT']) !!}
                                            <label>
                                                {!! Form::text('commission', $result->comission, ['class' => 'masksMoney', 'placeholder' => 'código']) !!}
                                            </label>
                                            <button type="submit" class="btn btn-small btn-popmartin">atualizar</button>
                                         {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                    @if($type === 'vendedor' && $result->store)
                    <div class="accordion-box">
                        <div class="accordion-header"><span class="c-pop fontw-500">Dados da loja:</span> <span
                                class="fa fa-chevron-right"></span></div>
                        <div class="accordion-content">

                            <div class="colbox">
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>Loja <a href="{{route('pages.store',$result->store->slug)}}" class="btn btn-smallextreme btn-popmartin fl-right"
                                                   target="_blank">ver
                                                loja</a></p>
                                        <span>{{$result->store->name}}</span>
                                    </div>
                                </div>
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>Nome fantasia</p>
                                        <span>{{($result->store->fantasy_name) ? $result->store->fantasy_name : 'não informado'}}</span>
                                    </div>
                                </div>
                                <div class="colbox-3">
                                    <div class="pop-info-user">
                                        <p>CNPJ</p>
                                        <span>{{($result->store->cnpj) ? $result->store->cnpj : 'não informado'}}</span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Razão Social</p>
                                        <span>{{($result->store->social_name) ? $result->store->social_name : 'não informado'}}</span>
                                    </div>
                                </div>
                                <div class="colbox-2">
                                    <div class="pop-info-user">
                                        <p>Contato</p>
                                        <span>{{$result->phone}} | {{$result->cellphone}} | {{$result->whatsapp}}</span>
                                    </div>
                                </div>
                                <div class="colbox-full">
                                    <div class="pop-info-user">
                                        <p>Endereço</p>
                                        @if($address = $result->store->adress)
                                            <span>{{ $address->public_place.' | '.$address->number }}
                                                {{ ($address->complements) ? ' ('.$address->complements.') |' : '| ' }}
                                                {{ $address->neighborhood.' | '.$address->city.' | '.$address->state.' | ' }}
                                                {{ $address->zip_code }}</span>
                                        @endif                                    </div>
                                </div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>