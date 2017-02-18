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
    $('.alertbox').height($(document).height() + 60);






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
 * Verificação de campo CPF
 * @param cpf
 * @returns {boolean}
 */
function is_cpf(cpf) {
    var exp = /[0-9]{3}[.][0-9]{3}[.][0-9]{3}[-][0-9]{2}/;
    if (exp.exec(cpf)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Vericar se o parâmetro informado, possui realmente um valor do formato data
 * Com ou sem hora
 * 1987-01-01 00:00:00
 * @param date - string
 * @param hour - boolean
 * @returns {boolean}
 */
function is_date(date, hour) {
    var exp = (hour ? /[0-9]{4}-[0-9]{2}-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}/ : /[0-9]{4}-[0-9]{2}-[0-9]{2}/);
    if (exp.exec(date)) {
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
 * Verifica se existe um número qualquer em uma determinada string
 * @param e
 * @returns {boolean}
 */
function is_numberString(e){
    var exp = new RegExp(/\d/);
    var response = exp.exec(e);
    console.log(response);
    if(response){
        return true;
    }else{
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
function compareLenght(v, c, n) {
    // console.log(c);
    if(c == "<"){
       return (v.length < n ? true : false);
    }else if(c == ">"){
        return (v.length > n ? true : false);
    }else if(c == "=="){
        return (v.length == n ? true : false);
    }else if(c == "!="){
        return (v.length != n ? true : false);
    }else if(c == "==="){
        return (v.length === n ? true : false);
    }else if(c == "!=="){
        return (v.length !== n ? true : false);
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
 * Incrementa uma pré visualização de uma img arquivada em um input qualquer do tipo file
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
    int: function(){
        var num = this.value;

        if (isNaN(num)) {
            num = num.substr(0, (num.length - 1));
        }
        this.value = num;
    },
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
 * <b>Exemplo:</b>
 *  <div class="checkbox-container padding10">
 *      <span>Cores</span>
 *      <div class="checkboxies">
 *          <label class="checkbox" style="border: none;">
 *             <span><span class="fa fa-circle-o"></span> Red</span>
 *             <input type="checkbox" name="cor[]" value="red">
 *         </label>
 *         <label class="checkbox" style="border: none;">
 *              <span><span class="fa fa-circle-o"></span> Black</span>
 *              <input type="checkbox" name="cor[]" value="black">
 *          </label>
 *      </div>
 *  </div>
 *
 */
function checkBox() {
    var e = $(this);
    if (e.is(":checked")) {
        e.siblings('span').find('span').attr("class", "fa fa-check-square-o").css({color: '#4CAF50'});
    } else {
        e.siblings('span').find('span').attr("class", "fa fa-square-o").css({color: '#626262'});
    }
};

/**
 * Estização para checkbox de formulário
 * <b>Exemplo:</b>
 *  <div class="checkbox-container padding10">
 *      <span>Gênero</span>
 *      <div class="checkboxies">
 *          <label class="radio" style="border: none;">
 *             <span><span class="fa fa-circle-o"></span> masculino</span>
 *             <input type="radio" name="genero" value="M">
 *         </label>
 *         <label class="radio" style="border: none;">
 *              <span><span class="fa fa-circle-o"></span> feminino</span>
 *              <input type="radio" name="genero" value="F">
 *          </label>
 *      </div>
 *  </div>
 */
function radiobox() {
    // var e = (e == 'undefined' ? $(this) : e);
    var e = $(this);
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

/**
 * Função para limitar quantidades de caracteres em um campo qualquer
 * estrutura básica:
 * <b>Exemplo:</b>
 *  <label>
 *      <textarea id="comments-limit" class="limiter-textarea" name="message" rows="4" maxlength="500"></textarea>
 *      <span class="limiter-result" for="comments-limit">limite de 500 caracteres</span>
 *  </label>
 */
function limiter() {
    var idElement = $(this).attr('id');
    var limiter = '';
    $(".limiter-result").each(function () {
        if ($(this).attr('for') === idElement) {
            limiter = $(this);
            return false;
        }
    });

    var max_limit = parseInt($(this).attr('maxlength'));
    var r = parseInt(max_limit - $(this).val().length);
    if (r <= 0) {
        $(this).val($(this).val().substr(0, (max_limit - 1)));
        r = '<span style="color: red;">limite de caracteres alcançado!</span>';
    }
    limiter.html(r);
}

/**
 * limpar Acentos e alguns caracteres de uma string qualquer
 * @param e
 * @returns {*}
 */
function cleanAccents(e){
    return strtr(
        'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ´`"\'~^',
        'AAAAAAACEEEEIIIIDNOOOOOOUUUUYbsaaaaaaaceeeeiiiidnoooooouuuyybyRr',
        e
    );
}

/**
 * Modificar string original de acordo comparâmetros de alterações passada
 * @param from
 * @param to
 * @param _in
 * @returns {string|*}
 */
function strtr(from, to, _in){
    var i,
        _this = _in.toString();
    from = (from + '').split('');
    to = (to + '').split('');
    i = from.length;

    while (i--)
    {
        if (_this.match(from[i])) {
            // Troca por to, Se to[i] não existir a nova char será vazia
            _this = _this.replace(new RegExp('\\' + from[i], 'ig'), (to[i] || ''));
        }
    }

    return _this;
}

/**
 * Verifica se a informação passada possui no mínimo 2 nomes separados por espaço
 * Característica de nomes completo
 * @param e
 * @returns {boolean}
 */
function fullname(e){
    var val = e.trim();
    if(val.indexOf(" ") < 1){
        return false;
    }else{
        return true;
    }
}
/**
 * Contar elementos de um objeto
 * @param obj
 * @returns {number}
 */
function objectLength(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
}


/*
 * EFEITO ACCORDION INPLEMENTAÇÂO
 * */
$(document).on("click", ".accordion-box .accordion-header", function () {
    if ($(".accordion-box .accordion-content").not($(this).siblings(".accordion-content")).is(":visible")) {
        $(".accordion-box .accordion-content").slideUp(600);
    }
    if ($(this).siblings('.accordion-content').is(":visible")) {
        $(this).find('.fa').attr("class", "fa fa-chevron-right");
    } else {
        $(this).find('.fa').attr("class", "fa fa-chevron-down");

    }
    $(this).siblings('.accordion-content').slideToggle(600);
});
/* ESTILIZAÇÃO DE FILE INPUT*/
$(document).on('change', "form input[type='file']", function () {
    var numArquivos = $(this).get(0).files.length;
    if (numArquivos > 1) {
        $(this).siblings("input[type='text']").val(numArquivos + ' arquivos selecionados');
    } else {
        $(this).siblings("input[type='text']").val($(this).val());
    }
    previewImg(this);
});
$(document).on('keyup', '.limiter-textarea', limiter);
$(document).on("keyup", ".masksInt", masks.int);
$(document).on("keypress", ".masksMoney", masks.money);
$(document).on("click", ".form-modern .checkbox input[type=checkbox]", checkBox);
$(document).on("click", ".form-modern .radio input[type=radio]", radiobox);
$(document).on("click", ".alertbox-close", function () {$(this).parents(".alertbox").hide(600);});







