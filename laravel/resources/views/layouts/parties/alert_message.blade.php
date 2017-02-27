<div class="alertbox" id="jq-new-message">
    <div class="alertbox-container">
        <span class="alertbox-close"><i class="fa fa-close fontem-18"></i></span>
        <div class="alertbox-content">
            <h2 class="alertbox-title c-pop fontw-500">Mensagem</h2>
            {!! Form::open(['route'=>['accont.message.comments',$type['type'], $type['id']],'method'=>'POST','class'=>'form-modern pop-form']) !!}
                {!! Form::textarea('message', null,['id' => 'msgS1', 'class' => 'limiter-textarea', 'maxlength' => '500', 'placeholder'=>'Informe aqui sua mensagem', 'rows'=>'7', 'data-required' => 'minlength', 'data-minlength' => 6]) !!}
                <span class="alert hidden"></span>
                <span class="limiter-result" for="msgS1" data-limit="500">500</span>
                <div class="clear-both"></div>
                <div class="txt-center">
                    <button type="submit" class="btn btn-popmartin">enviar</button>
                    <button type="reset" class="btn btn-gray jq-close-alertbox">cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
