$(function () {
    var urlBase = window.location.origin;

    $('.navicon-mobile').click(function () {
        $(this).siblings('.nav-mobile').slideToggle();
    });

    $('.alertbox').height($(document).height());

});

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

function is_null(data) {
    if (data === null || data.strlen === 0) {
        return false;
    } else {
        return true;
    }
}

function is_Number(val) {
    return typeof val === "number"
}

function is_count(n, v) {
   if(v.length < n){
       return false;
   }else{
       return true;
   }
}
function maskInt(t) {
    var num = t.value;

    if (isNaN(num)) {
        num = num.substr(0, (num.length - 1));
    }
    t.value = num;
}

/**
 * AJAX COM INFORMAÇÃO DE FORMULÁRIOS
 */
$(document).on("submit", ".JQ-ajaxform", function () {
    var data = $(this).serialize() + '&' + nametoken + '=' + keytoken;
    $.ajax({
        url: '/ajaxcrud',
        data: data,
        type: 'POST',
        dataType: 'json',
        beforeSend: function () {
            $(".ajax-result").html('<span class="spinner spinner--steps icon-spinner fontem-12" style="color: #666;"></span>');
        },
        success: function (e) {
            $(".ajax-result").html(e.result);
        }
    });

    return false;
});

$(document).on("click", ".alertbox-close", function () {
    $(this).parents(".alertbox").hide(600);
});

/*
 * EFEITO ACCORDION
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

function previewFile(t) {
    var p = '';
    $(".prevImg").each(function(a){
        if($(".prevImg").eq(a).data('preview') == t.data("preview")){
            // alert($(".prevImg").eq(a).data('preview') + '-' + t.data("preview"));
            p = $(".prevImg").eq(a);
        }
    });

    var preview = p;
    if (t.files && t.files[0]) {


    }
    alert(file);
    // var file    = t.files[0];
    var reader  = new FileReader();

    reader.onloadend = function (e) {
        p.html('<img src="' + e.target.result + '">');
    }

    if (t.files[0]) {
        reader.readAsDataURL(t.files[0]);
    } else {
        preview.src = "";
    }
}



function previewImg(e) {
    $(".prevImg").each(function(a){
        alert($(this).eq(a).attr('data-preview') + '-' + e.getAttribute("data-preview"));
        // if($(this).eq(a).data('preview') == e.getAttribute("data-preview")){
        //
        // }
    });
    if (e.files && e.files[0]) {

        console.log(e.files[0]);

        var reader = new FileReader();
        reader.onload = function (e) {
            // console.log(e);
            $(".prevImg").html('<img src="' + e.target.result + '">');
        };
        console.log(reader);
        reader.readAsDataURL(e.files[0]);
    }
    else {
        // console.log("info");
        var img = e.value;
        p.find(".prevImg").html('<img src="' + img + '">');
    }
}

var masks = {
    money: function() {
        var el = this
            ,exec = function(v) {
            v = v.replace(/\D/g,"");
            v = new String(Number(v));
            var len = v.length;
            if (1== len)
                v = v.replace(/(\d)/,"0.0$1");
            else if (2 == len)
                v = v.replace(/(\d)/,"0.$1");
            else if (len > 2) {
                v = v.replace(/(\d{2})$/,'.$1');
            }
            return v;
        };

        setTimeout(function(){
            el.value = exec(el.value);
        },1);
    }
}
/**
 * Estização para checkbox de formulário
 * @param e
 */
function checkBox(e) {
    if(e.is(":checked")){
        e.siblings('span').find('span').attr("class", "fa fa-check-square-o c-green").css({color: '#4CAF50'});
    }else{
        e.siblings('span').find('span').attr("class", "fa fa-circle-o").css({color: '#626262'});
    }
};

/**
 * Estização para checkbox de formulário
 * @param e object html DOM
 */
function radiobox(e) {
    if(e.is(":checked")){
        $("input[type=radio]").each(function(){
            if($(this).attr('name') == e.attr('name')){
                $(this).siblings('span').find('span').attr("class", "fa fa-circle-o").css({color: '#626262'});
            }
        });
        e.siblings('span').find('span').attr("class", "fa fa-check-circle-o c-green").css({color: '#4CAF50'});
    }else{
        e.siblings('span').find('span').attr("class", "fa fa-circle-o").css({color: '#626262'});
    }
};

$(document).on("keypress", ".masksMoney", masks.money);
$(document).on("click", ".form-modern .checkbox input[type=checkbox]", function(){checkBox($(this))});
$(document).on("click", ".form-modern .radio input[type=radio]", function(){radiobox($(this))});