/**
 * Criado por asiw
 * @author: asiw - contato@asiw.com.br
 */

var alertfyConfirmTitle = 'Pop Martin alerta!';
$(function () {
    /**
     * Carousel para container de publicidade no topo do site
     * @type {{loop: boolean, margin: number, responsive: {0: {items: number}, 400: {items: number}, 600: {items: number}, 700: {items: number}, 900: {items: number}}, autoplay: boolean, autoplayTimeout: number, autoplayHoverPause: boolean}}
     */
    var owlAds = {
        loop: true,
        margin: 30,
        responsive: {0: {items: 1}, 400: {items: 2}, 600: {items: 3}, 700: {items: 4}, 900: {items: 5}},
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
    }

    /**
     * Carousel para container de apresentação de produtos na página inicial do site
     * @type {{loop: boolean, margin: number, nav: boolean, navText: [*], dots: boolean, responsive: {0: {items: number}, 400: {items: number}, 600: {items: number}, 700: {items: number}, 900: {items: number}}, autoplay: boolean, autoplayTimeout: number, autoplayHoverPause: boolean}}
     */
    var owlHomeProducts = {
        loop: true,
        margin: 30,
        nav: true,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        dots: false,
        responsive: {0: {items: 1}, 400: {items: 2}, 600: {items: 3}, 700: {items: 4}, 900: {items: 5}},
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
    };

    /**
     * Aplica argumentos passados por uma função de macaramento de telefone ou celular
     * @type {{onKeyPress: onKeyPress}}
     */
    var phoneOptions = {
        onKeyPress: function (val, e, field, options) {
            field.mask(fullPhone.apply({}, arguments), options);
        }
    };

    /** Inicia plugin tooltipster */
    $('.tooltip').tooltipster();

    /** Iniciar carrousel para anúncios no topo do site */
    $(".pop-ads").owlCarousel(owlAds);

    /** Iniciar carrousel para exibição de produtos na home do site */
    $(".pop-home-prd").owlCarousel(owlHomeProducts);

    /** Abrir modal de mensagems */
    $(".jq-new-message").click(function () {
        $("#jq-new-message").show();
    });

    /**
     * Verifica os input segundo as regras atribuídas
     * Retorna falso se alguma verificação dê errado */
    $('.form-modern').each(function () {
        checkForm($(this));
        $(this).submit(function () {
            if (!checkSubmit($(this))) {
                return false;
            }
        });
    });

    /** Trata a url para destinar a pesquisa no site */
    $('.pop-search').submit(function () {
        var val = ($(this).find("input[name=search]").val() != '' ? $(this).find("input[name=search]").val() : 'pesquisa');
        window.location = $(this).attr('action') + '/' + val;
        return false;
    });

    /** Abrir modal de avaliação */
    $(".jq-new-rating").click(function () {
        $("#jq-new-rating").show();
    });

    /** Efeito slidetoogle do menu no topo com nome do usuário */
    $('.pop-top-header').find('.menu > a').click(function () {
        $(this).siblings('.menu-hidden').slideToggle();
    });

    /**
     * Abre modal com formulário de preenchimento de endereço
     * Requisita endereço via ajax caso seja uma edição
     * Caso seja um cadastro, apnenas abre para preenchimento
     */
    $(document).on('click', '.jq-address', function () {
        var form = $('#form-adress');
        $(".alertbox .alertbox-container").css({top: $(document).scrollTop()});
        var action = $(this).data('action')
        if (action == 'store') {
            form.find("label span").first().text('Loja');
            form.find("label input").first().val('Endereço').attr('readonly', true);
        }
        if (typeof ($(this).data('id')) !== "undefined") {
            $('.alertbox-title').text('Editar endereço');
            $('.address_remove').html('<span class="btn btn-small btn-red jq-remove-address" data-id="' + $(this).data('id') + '"><i class="fa fa-trash"></i> remover endereço</span>');
            $('.address').find('button').text('atualizar');
            $.ajax({
                url: '/accont/adresses/' + action + '/' + $(this).data('id'),
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    form.find('.loader-address').show();
                },
                error: function (response) {
                    form.find('.loader-address').hide();
                    alertify.error(response.responseJSON.msg);
                },
                success: function (response) {
                    form.find('.loader-address').hide();
                    inputValue(form, response);
                }
            });
        } else {
            $('.alertbox-title').text('Cadastrar endereço');
            $('.address').find('button').text('cadastrar');
        }
        $('.address').find('form').attr('data-action', action);
        $('.address').show();
    });

    /** Remover enderço do usuário */
    $(document).on('click', '.jq-remove-address', function () {
        var element = $(this);
        alertify.confirm(alertfyConfirmTitle, 'Tem certeza de que deseja remover este endereço?',
            function () {
                var id = element.data('id');
                $.get('/accont/adresses/destroy/' + id, function (response) {
                    if (response.status) {
                        alertify.success('Endereço removido!');
                    } else {
                        alertify.error(response.msg);
                    }
                }, 'json');
                $('.alertbox-close').click();
            }, function () {
                return true;
            });
        return false;
    });

    /** Máscara de telefone e celular. */
    $('.celphone').on('focusout', function (e) {
        if (!(/\([0-9]{2}\)[\s][0-9]{4,5}-[0-9]{4}/.test($(this).val()))) {
            $(this).val('');
            $(this).next('span').removeClass('hidden').text('Telefone inválido');
        }
    });

    /** Limpesa de campos ao fechar um alertbox */
    $('.alertbox-close').click(function () {
        var form = $(this).siblings('div').find('form');
        clearInput(form);
        if (form.find(":checkbox").is(":checked")) {
            form.find(":checkbox").click();
        }
        $('.jq-remove-address').hide();
    });

    /** Eventos para a troca de imagens da galeria */
    $(".pop-product-galery img").click(function () {
        $(this).parent().siblings().css({opacity: 0.5})
        $(this).parent().css({opacity: 1});
        var src = $(this).attr('src');
        var src = src.split('?');
        var newSrc = src[0] + '?w=500&h=500&fit=crop';
        $("#img-product").attr('src', newSrc);
    });

    /** Abrir modal para adionar observação ao pedido no carrinho */
    $('.show-formobs').click(function () {
        $(this).hide().siblings('form').show().find('textarea').focus();
    });

    /** Fecha formulário de observação e retorna o botão de abri-lo novamente */
    $('.pop-cart-obs form a').click(function () {
        $(this).parents('form').hide().siblings('.show-formobs').show();
    });

    /** Fechar alertbox padrão de forma personalizada usando a class "jq-close-alertbox" */
    $('.jq-close-alertbox').on('click', function () {
        $('.alertbox-close').click();
    });

    /**  abri container de infomações de acordo com o titulo na página de produtos */
    $(document).on('click', '.wt-header span', function () {
        windowToggle($(this), 'wt-selected');
    });

    /** definir um loading padrão nos botões de submit de fomulários*/
    $(document).on('submit', '.form-modern', function () {
        $(this).find("button[type=submit]").html('<i class="fa fa-spin fa-spinner vertical-middle"></i> aguarde...').css({background: '#E57373'});
    });

    /** Chamada de função para remoção de produtos */
    $(document).on('click', '.jq-remove-product', removePrduct);

    /** Chamada de função para remoção de galerias relaciona a produtos */
    $(document).on('click', '.jq-remove-img-galery', removeImgGarely);

    /** Chamada de função para bloquear ou desbloqueer loja */
    $(document).on('click', '.jq-block-store', blockStore);

    /** Configuração de maskaras para campos input de formulários */
    $(".masked_date").mask("00/00/0000", {placeholder: "mm/dd/yyyy"});
    $(".masked_phone").mask("(00) 0000-0000");
    $(".masked_cellphone").mask("(00) 00000-0000");
    $(".masked_cpf").mask("000.000.000-00");
    $(".masked_cnpj").mask("00.000.000/0000-00");
    $('.masked_fullphone').mask(fullPhone, phoneOptions);
});

/**
 * Resetar select
 * @param e
 */
function resetChange(e) {
    e.children().removeAttr('selected');
}

/**
 * verivica se um determinado grupo de mensagens de array estão checados(marcados) ou não
 * Retorna um array com a posição index e os valores dos inputs marcados respectivamente
 * @param class_element - classe em comun dos elementos
 * @returns {Array}
 */
function checkInputsMsg(class_element) {
    var status = [];
    $('.' + class_element).each(function () {
        var idx = $(this).index('.' + class_element);
        if ($(this).is(':checked')) {
            status[idx] = $(this).val();
        }
    });
    return status;
}

/**
 * Verifica qual o campo do input para filtrar de acordo com sua característica
 * @param t object html DOM <input>
 * @returns {boolean}
 */
function switchForm(t) {
    var r = false;
    switch (t.data('required')) {
        case 'minlength':
            r = inputError(!compareLenght(t.val(), '<', t.data('minlength')), t, 'Campo deve ter no mínimo ' + t.data('minlength') + ' caracteres');
            break;
        case 'notnull':
            r = inputError(!compareLenght(t.val(), '<', 1), t, 'Campo não pode ser vazio');
            break;
        case 'notzero':
            r = inputError(!(t.val() < 1), t, 'Campo não pode ser zero');
            break;
        case 'fullname':
            r = inputError(fullname(t.val()), t, 'Nome completo inválido');
            break;
        case 'name':
            var response = function () {
                if (is_numberString(t.val()) || compareLenght(t.val(), '<', 2)) {
                    return false;
                } else {
                    return true;
                }
            }
            r = inputError(response(), t, 'Nome inválido!');
            break;
        case 'last_name':
            var response = function () {
                if (is_numberString(t.val()) || compareLenght(t.val(), '<', 2)) {
                    return false;
                } else {
                    return true;
                }
            }
            r = inputError(response(), t, 'Sobrenome inválido!');
            break;
        case 'email':
            r = inputError(is_mail(t.val()), t, 'e-mail inválido!');
            break;
        case 'email_confirm':
            var response = function () {
                if (!is_mail(t.val()) || (t.val() != t.parents('form').find('input[name=email_register]').val())) {
                    return false;
                } else {
                    return true;
                }
            }
            r = inputError(response(), t, 'e-mail não confere');
            break;
        case 'cpf':
            var response = function () {
                if (compareLenght(t.val(), '<', 14) || !is_cpf(t.val())) {
                    return false;
                } else {
                    return true;
                }
            }
            r = inputError(response(), t, 'cpf inválido!');
            break;

        case 'fullphone':
            r = inputError(!compareLenght(t.val(), '<', 14), t, 'Telefone inválido');
            break;
        case 'cellphone':
            r = inputError(!compareLenght(t.val(), '<', 15), t, 'Telefone inválido');
            break;
        case 'whatsapp':
            r = inputError(!compareLenght(t.val(), '<', 14), t, 'Whatsapp inválido');
            break;
        case 'password':
            r = inputError(!compareLenght(t.val(), '<', 6), t, 'senha deve ter no mínimo 6 caracteres!');
            break;
        case 'password_confirm':
            var response = function () {
                if (compareLenght(t.val(), '<', 6) || (t.val() != t.parents('form').find('input[name=password_register]').val())) {
                    return false;
                } else {
                    return true;
                }
            }
            r = inputError(response(), t, 'senha não confere!');
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
function checkForm(f) {
    f.find("input").focusout(function () {
        var t = $(this);
        switchForm(t);
    }).focusin(function () {
        $(this).removeClass('input-error').siblings('.alert').addClass('hidden');
    });
    f.find("textarea").focusout(function () {
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
function checkSubmit(f) {
    var r = false;
    if (f.find('input').length) {
        f.find('input').each(function () {
            var t = $(this);
            r = switchForm(t);
            if (!r) {
                return false;
            }
        });
    } else {
        return true;
    }
    return r;
}
/**
 * Verifica de o campo input. Se is retorna false, gera um erro
 * @param is retorno de uma função de verificação
 * @param param object html DOM <input>
 * @param msg string mensagem a ser apresentada
 * @returns {boolean}
 */
function inputError(is, param, msg) {
    if (!is) {
        param.addClass('input-error').siblings('.alert').removeClass('hidden').text(msg);
        return false;
    } else {
        return true;
    }
}

/**
 * Recebe um objeto e faz iteração neles passando pra uns inputs
 * @param inputs object
 */
function inputValue(e, inputs) {
    if (inputs instanceof Object) {
        $.each(inputs, function (index, element) {
            if (element) {
                if (index === 'state') {
                    element = element.substr(0, 2);
                }
                if (!is_Number(element)) {
                    element = element.replace(/\s+/g, " ");
                }
                e.find('input[name=' + index + ']').val(element);
                var master = $("#form-adress .checkbox").find("input[name=master]");
                if (index === 'master' && element) {
                    $("#form-adress .checkbox").find('.fa').attr('class', 'fa fa-check-square-o');
                    if (!master.is(":checked")) {
                        master.click();
                    }
                } else {
                    if (master.is(":checked")) {
                        master.click();
                    }
                }
            }
        });
    }
}

/**
 * Limpar campo de input exceto token
 * @param form
 */
function clearInput(form) {
    var _token = form.find('input[name=_token]').val();
    form.find('input').val('');
    form.find('input[name=_token]').val(_token);
}

/**
 * Determina máscara para telefones variados
 * @param val
 * @returns {string}
 */
function fullPhone(val){
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
}