/**
 * Created by Bruno Moura on 15/01/2017.
 */
$(function () {
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 10,
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 2
            },
            600: {
                items: 3
            },
            700: {
                items: 4
            },
            900: {
                items: 5
            }
        }
    });

    $('.form-modern').each(function () {
        verificaform($(this));
        $(this).submit(function(){
            if(!verificaform($(this))){
                return false;
            }
        });
    });
});

function verificaform(f){
    f.find("input").focusout(function () {
        var t = $(this);
        switch (t.attr('name')){
            case 'email':
                inputerror(is_mail(t.val()), t, 'e-mail inválido!');
                break;
            case 'password':
                inputerror(is_count(6, t.val()), t, 'senha deve ter no mínimo 6 caracteres!');
                break;
        }
    }).focusin(function(){
        $(this).removeClass('input-error').siblings('.alert-hidden').hide();
    });
}
function inputerror(is, param, msg){
    if(!is){
        param.addClass('input-error').siblings('.alert-hidden').show().text(msg);
        return false;
    }
}