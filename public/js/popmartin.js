/**
 * Created by asiw.com.br on 16/01/2017.
 */
$(function () {

    /**
     * Estilização dos banners de anúncios usando o plugin owlCarousel
     */
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        responsive: {0: {items: 1}, 400: {items: 2}, 600: {items: 3}, 700: {items: 4}, 900: {items: 5}}
    });

    /**
     * Verifica os input segundo as regras atribuídas e para a escução caso haja um submit
     */
    $('.form-modern').each(function () {
        verificaform($(this));
        $(this).submit(function () {
            if (!verifySubmit($(this))) {
                return false;
            }
        });
    });

    /**
     * efeito slidetoogle do menu no topo com nome do usuário
     */
    $('.pop-top-header').find('.menu > a').click(function () {
        $(this).siblings('.menu-hidden').slideToggle();
        return false;
    });

    /**
     * Abre modal com formulário de preenchimento de endereço
     * Requisita endereço via ajax caso seja uma edição
     * Caso seja um cadastro, apnenas abre para preenchimento
     */
    $(document).on('click', '.jq-address', function(){
        if(typeof ($(this).data('id')) !== "undefined"){
            $('.alertbox-title').text('Editar endereço');
            $('.address').find('button').text('atualizar');
            var data = 'token=token&action=requestAddress&id=' + $(this).data('id');
            $.ajax({
                url: '',
                data: data,
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {

                },
                success: function (e) {

                }
            });
        }else{
            $('.alertbox-title').text('Cadastrar endereço');
            $('.address').find('button').text('cadastrar');
        }

        $('.address').show();
    });

    /**
     * Menu mobile do painel de administração dos usuários
     */
    $('.panel-icon-mobile').click(function () {
        if($('.panel-nav').is(':visible')){
            $(this).find('i').attr('class', 'fa fa-chevron-down');
        }else{
            $(this).find('i').attr('class', 'fa fa-chevron-up');
        }
        $('.panel-nav').slideToggle();
    });

    $(".searh_store input[name=search_store]").keyup(function () {
        var data = 'token=token&action=searchStore&value=' + $(this).val();
        var implementTr = $('#pop-searchStore tbody');
        $.ajax({
            url: '',
            data: data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                implementTr.html("<tr><td colspan=\"3\"><i class='fa fa-spin fa-spinner'></i> procurando...</td></tr>")
            },
            success: function (e) {
                implementTr.html(e.resulttr);
            }
        });
    });

});

/**
 * Verifica qual o campo do input para filtrar de acordo com sua característica
 * @param t object html DOM <input>
 * @returns {boolean}
 */
function switchForm(t){
    var r = false;
    switch (t.attr('name')) {
        case 'email':
            r = inputerror(is_mail(t.val()), t, 'e-mail inválido!');
            break;
        case 'password':
            r = inputerror(is_count(6, t.val()), t, 'senha deve ter no mínimo 6 caracteres!');
            break;
        default:
            r = true;
    }
    return r;
}

/**
 * verifica os input de acordo com as regras estipuladas e chama uma função que determina um erro
 * @param object html DOM
 */
function verificaform(f) {
    f.find("input").focusout(function () {
        var t = $(this);
        switchForm(t);
    }).focusin(function () {
        $(this).removeClass('input-error').siblings('.alert').addClass('hidden');
    });
}
/**
 * Verifica os campos do formulário para acionar uma ação
 * @param f object html DOM <form>
 * @returns {boolean}
 */
function verifySubmit(f){
    var r = false;
    f.find('input').each(function(){
        var t = $(this);
        r = switchForm(t);
        if(!r){
            return false;
        }
    });
    return r;
}
/**
 * Verifica de o campo input. Se is retorna false, gera um erro
 * @param is retorno de uma função de verificação
 * @param param object html DOM <input>
 * @param msg string mensagem a ser apresentada
 * @returns {boolean}
 */
function inputerror(is, param, msg) {
    if (!is) {
        param.addClass('input-error').siblings('.alert').removeClass('hidden').text(msg);
        return false;
    }else{
        return true;
    }
}