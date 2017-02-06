<div class="alertbox" id="jq-notification">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title">Notificação</h2>
            <p>Notificação de alerta de mensagem suspeita</p>
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
                    <td class="txt-center">658</td>
                    <td>Nome completo do remetente</td>
                    <td>email@email.com</td>
                </tr>
                <tr>
                    <td class="t-status">Destinatário</td>
                    <td>256</td>
                    <td>Nome completo do destinatário</td>
                    <td>email@email.com</td>
                </tr>
                </tbody>
            </table>
            <span class="dp-block fontw-500 c-pop">Menssagem relacionada:</span>
            <span class="dp-block"><b>Id:</b> 568 </span>
            <div class="">
                <form class="form-modern">
                    <label>
                        {!! Form::textarea('content', 'Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI,',
                    ['id' => 'msg-notify', 'class' => 'limiter-textarea', 'maxlength' => '500']) !!}
                        <span class="limiter-result" for="msg-notify" data-limit="500">500</span>
                    </label>

                    <div class="txt-center">
                        <button type="submit" name="edit" class="btn btn-popmartin">editar</button>
                        <button type="submit" name="edit" class="btn btn-red"><i class="fa fa-trash"></i> remover</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>