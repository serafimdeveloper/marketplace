$(function () {
    var urlBase = window.location.origin;

    if ($(".ajax-trigger:visible")) {
        setTimeout(function () {
            $(".ajax-trigger").animate({
                right: '-100%'
            }, 1700);
        }, 3000);
    }

    $('.navicon-mobile').click(function () {
        $(this).siblings('.nav-mobile').slideToggle();
    });

    /** altura da modal lightbox */
    $('.alertbox').height($(document).height());

    /* ESTILIZAÇÃO DE FILE INPUT*/
    $("form input[type='file']").on('change', function () {
        var numArquivos = $(this).get(0).files.length;
        if (numArquivos > 1) {
            $(this).siblings("input[type='text']").val(numArquivos + ' arquivos selecionados');
        } else {
            $(this).siblings("input[type='text']").val($(this).val());
        }
        previewImg(this);
    });

});

/**
 * Transforma array em objeto javascript
 * @param array
 * @returns {*}
 */
function arrayToObject(array) {
    var obj = array.reduce(function (acc, cur, i) {
        acc[i] = cur;
        return acc;
    }, {});

    return obj;
}

/**
 * VALIDAÇÃO DE E-MAIL COM EXPRESSÃO REGULAR FORNECIDA PELA W3C HTML
 * @param {string} mail
 * @returns {Boolean}
 */
function is_mail(mail) {
    var expMail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    if (expMail.exec(mail)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Verifica se um determinado valor passado como parâmetro é vazio
 * @param data
 * @returns {boolean}
 */
function is_null(data) {
    if (data === null || data.strlen === 0) {
        return true;
    } else {
        return false;
    }
}
/**
 * Verifica se um determinado valor passado como parâmetro é u, múmero
 * @param val
 * @returns {boolean}
 */
function is_Number(val) {
    return typeof val === "number"
}

/**
 * Verifica a quantidade de caracteres de um campo de acordo com o valor passado "v"
 * @param n
 * @param v
 * @returns {boolean}
 */
function is_count(n, v) {
    if (v.length < n) {
        return false;
    } else {
        return true;
    }
}
/**
 * Máscara para números inteiros em um campo input
 * @param t
 */
function maskInt(t) {
    var num = t.value;

    if (isNaN(num)) {
        num = num.substr(0, (num.length - 1));
    }
    t.value = num;
}

$(document).on("click", ".alertbox-close", function () {
    $(this).parents(".alertbox").hide(600);
});

/*
 * EFEITO ACCORDION INPLEMENTAÇÂO
 * */
$(document).on("click", ".accordion-box .accordion-header", function (e) {
    if ($(".accordion-box .accordion-content").not($(this).siblings(".accordion-content")).is(":visible")) {
        $(".accordion-box .accordion-content").slideUp(600);
    }
    if ($(this).siblings('.accordion-content').is(":visible")) {
        $(this).find('.icon').attr("class", "icon icon-arrow-right2");
    } else {
        $(this).find('.icon').attr("class", "icon icon-arrow-down2");

    }
    $(this).siblings('.accordion-content').slideToggle(600);
});

/**
 * Verifica se um determinado elemento está visivel ou não ao manuseal o scroll do navegador
 * @param e
 * @returns {boolean}
 */
function isScrollVisibleElement(e) {
    var docViewTop = $(window).scrollTop;
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(e).offset().top;
    var elemBottom = elemTop + $(e).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

/**
 * Incrementa uma pré visualização de uma imagem arquivada em um input qualquer do tipo file
 * @param e
 */
function previewImg(e) {
    var prevImg = document.getElementById('preview_img' + e.getAttribute('data-preview'));
    console.log(prevImg);
    if (e.files && e.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            // console.log(e);
            prevImg.innerHTML = '<img src="' + e.target.result + '">';
        };
        reader.readAsDataURL(e.files[0]);
    }
    else {
        var img = e.value;
        prevImg.html('<img src="' + img + '">');
    }
}

/**
 * Máscara de formato dinheiro em tempo real embutido no campo de imput
 * usando class="masksMoney"
 * @type {{money: masks.money}}
 */
var masks = {
    money: function () {
        var el = this
            , exec = function (v) {
            v = v.replace(/\D/g, "");
            v = new String(Number(v));
            var len = v.length;
            if (1 == len)
                v = v.replace(/(\d)/, "0.0$1");
            else if (2 == len)
                v = v.replace(/(\d)/, "0.$1");
            else if (len > 2) {
                v = v.replace(/(\d{2})$/, '.$1');
            }
            return v;
        };

        setTimeout(function () {
            el.value = exec(el.value);
        }, 1);
    }
}
/**
 * Estização para checkbox de formulário
 * @param e
 */
function checkBox(e) {
    if (e.is(":checked")) {
        e.siblings('span').find('span').attr("class", "fa fa-check-square-o").css({color: '#4CAF50'});
    } else {
        e.siblings('span').find('span').attr("class", "fa fa-square-o").css({color: '#626262'});
    }
};

/**
 * Estização para checkbox de formulário
 * @param e object html DOM
 */
function radiobox(e) {
    if (e.is(":checked")) {
        $("input[type=radio]").each(function () {
            if ($(this).attr('name') == e.attr('name')) {
                $(this).siblings('span').find('span').attr("class", "fa fa-circle-o").css({color: '#626262'});
            }
        });
        e.siblings('span').find('span').attr("class", "fa fa-check-circle-o c-green").css({color: '#4CAF50'});
    } else {
        e.siblings('span').find('span').attr("class", "fa fa-circle-o").css({color: '#626262'});
    }
};

/**
 * Abrir e fechar containers unsando menu em um bloco fechado
 * @param e - menu
 * @param selector - class de estização a ser integrada ao abrir um container
 */
function windowToggle(e, selector) {
    var content = e.parent().siblings('div');
    content.children().each(function () {
        if (content.children().eq(e.index()).is(":hidden")) {
            e.siblings().removeClass(selector);
            e.addClass(selector);
            content.children().hide().removeClass(selector);
            content.children().eq(e.index()).show().addClass(selector);
        }
    });
}

$(document).on("keypress", ".masksMoney", masks.money);
$(document).on("click", ".form-modern .checkbox input[type=checkbox]", function(){checkBox($(this))});
$(document).on("click", ".form-modern .radio input[type=radio]", function(){
    radiobox($(this))
});







