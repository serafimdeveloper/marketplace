<div class="alertbox" id="alert-notification" style="display: block;">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title">Notificação</h2>
            <p>Notificação mensagem suspeita <br>
                <b>Motivo: </b> <span class="c-red">{{ $ntf->reason }}</span>
            </p>
            <table id="jq-search-table-result" class="table table-action">
                <thead>
                <tr>
                    <th class="t-medium"></th>
                    <th class="t-small txt-center">Id</th>
                    <th>Nome</th>
                    <th class="t-medium">E-mail</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td class="t-status">Remetente</td>
                    <td class="txt-center">{{ $sender['id'] }}</td>
                    <td>{{ $sender['name'] }} {{ isset($sender['store']) ? ' ( ' . $sender['store']->name . ' ) ' : '' }}</td>
                    <td>{{ $sender['email'] }}</td>
                </tr>
                <tr>
                    <td class="t-status">Destinatário</td>
                    <td>{{ $recipient['id'] }}</td>
                    <td>{{ $recipient['name'] }} {{ isset($recipient['store']) ? ' ( ' . $recipient['store']->name . ' ) ' : '' }}</td>
                    <td>{{ $recipient['email'] }}</td>
                </tr>
                </tbody>
            </table>
            <span class="dp-block fontw-500 c-pop">Mensagem relacionada:</span>
            <span class="dp-block"><b>Id:</b> {{ $ntf->message->id }} </span>
            <div class="">
                <form class="form-modern pop-form form-notfy">
                    {!! csrf_field() !!}
                    <input type="hidden" name="message_id" value="{{ $ntf->message->id }}">
                    <label>
                        {!! Form::textarea('content', $ntf->message->content,
                    ['id' => 'msg-notify', 'class' => 'limiter-textarea', 'maxlength' => '500']) !!}
                        <span class="limiter-result" for="msg-notify" data-limit="500">500</span>
                    </label>

                    <div class="colbox">
                        <div class="colbox-2 txt-left">
                            <button type="submit" class="btn btn-small btn-popmartin"><i class="fa fa-edit vertical-middle"></i> editar mensagem</button>
                        </div>
                        <div class="colbox-2 txt-right">
                            <a class="btn btn-small btn-red adm-remove-message" data-id="{{ $ntf->message->id }}" data-token="{{ csrf_token() }}">
                                <i class="fa fa-trash"></i>
                                remover mensagem
                            </a>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                </form>
            </div>
        </div>
    </div>
</div>