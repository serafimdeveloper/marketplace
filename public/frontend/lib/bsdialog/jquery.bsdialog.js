(function ($) {
    // <span class="bs-dialog-close fa fa-close"></span>
    $.fn.bsdialog = function (option) {
        var el_class = "bs-dialog";
        var el_classBody = "bs-dialog-body";
        var el_classTitle = "bs-dialog-title";
        var el_classContent = "bs-dialog-content";
        var el_classClose = "bs-dialog-close";
        var el_classFooter = "bs-dialog-footer";


        var el = $('.' + el_class);
        var defaults = {
            type: 'message',
            close: false,
            width: '50%',
            minWidth: '200',
            maxWidth: '400',
            description: 'Lorem Ipsum é simplesmente uma simulação de texto da indústria'
        }
        var settings = $.extend({}, defaults, option);


        /**
         * Abrir Dialog com argumentos passados como parâmetros
         * @param args
         */
        function open(args) {
            createDialog(args);
            el.show();
        }

        /**
         * Fechar e limpar Dialog
         */
        function closeDialog() {
            el.unwrap().hide().html('');
        }

        /**
         * Criar Dialogo com argumentos passados
         * @param args
         */
        function createDialog(args) {
            el.wrap('<div class="' + el_classBody + '"></div>');
            var window = '<p class="' + el_classTitle + '">' + el.attr('title') + '<span class="' + el_classClose + '" onclick="$(document).bsdialog({close: true})">x</span></p>';
            window += '<div class="' + el_classContent + '">';
            window += args;
            window += '</div>';
            window += '<div class="'+el_classFooter+'">';
            window += defineButtons();
            window += '</div>';
            el.html(window);
            $(".bs-dialog-body").height($(document).height());
            positionDialog();
            el.draggable();

            console.log(window);
        }

        /**
         * Definição de estilização do Dialog
         */
        function styleDialog() {
            el.css({width: settings.width, 'min-width': settings.minWidth, 'max-width': settings.maxWidth});
        }

        /**
         * verifica a tela para abrir a caixa de diálogo no meio da tela
         */
        function positionDialog() {
            styleDialog();
            var x = ($(document).scrollTop() + 100);
            var y = ($(window).width() / 2) - (el.width() / 2);
            el.css({top: x, left: y});
        }


        /**
         * Estruturação de Formulário padrão
         * @returns {{attr: {name: string, action: string, method: string}, inputs: {text: {name: {placeholder: string}}, textarea: {textarea: {placeholder: string, value: string}}}}}
         */
        function patternForm() {
            return {
                attr: {name: 'form', action: "", method: 'POST'},
                inputs: {
                    text: {
                        name: {placeholder: 'name'},
                    },
                    textarea: {
                        textarea: {placeholder: 'Redija aqui', value: 'Valor para este campo'},
                    }
                }
            }
        }

        /**
         * Retorna formulário criado e pronto pra ser implementado
         * @returns {string}
         */
        function createForm() {
            var elform;
            if (!checkForm()) {
                elform = patternForm();
            } else {
                elform = settings.form;
            }
            var form = '<form';
            $.each(elform.attr, function (index, value) {
                form += ' ' + index + '="' + value + '"';
            });
            form += '>';
            $.each(elform.inputs, function (index, value) {
                if (index !== 'textarea') {
                    $.each(value, function (index1, value2) {
                        form += '<input type="' + index + '"';
                        form += ' name="' + index1 + '"';
                        $.each(value2, function (index3, value3) {
                            form += ' ' + index3 + '="' + value3 + '"';
                        });
                        form += '>';
                    });
                } else {
                    $.each(value, function (index1, value2) {
                        var valuetexarea = '';
                        form += '<textarea';
                        form += ' name="' + index1 + '"';
                        $.each(value2, function (index3, value3) {
                            if (index3 !== 'value') {
                                form += ' ' + index3 + '="' + value3 + '"';
                            } else {
                                valuetexarea = value3;
                            }
                        });
                        form += '>' + valuetexarea + '</textarea>';
                    });
                }
            });
            form += '</form>';
            return form;
        }

        /**
         * Verifica se form está ativo ou não
         * @returns {boolean}
         */
        function checkForm() {
            if(settings.form == 'undefined' || settings.form == null || settings.form == false){
                return false
            }else{
                return true;
            }
        }

        function defineButtons(){
            // '+$(this).parents("."+ el_class).find('form').submit()+'
            var btn = '';
            if(settings.type === 'form'){
                btn += '<button class="bsbtn bsbtn-accept" onclick="">Enviar</button> ';
            }
            btn += '<button class="bsbtn bsbtn-cancel" onclick="$(document).bsdialog({close: true})">cancelar</button>';

            return btn;
        }
        return this.each(function () {
            if (settings.close === true) {
                closeDialog();
            } else {
                switch (settings.type) {
                    case 'form':
                        open(createForm());
                        break;
                    case 'alert':
                        break;
                    case 'message':
                        console.log("message");
                        break;
                    default:
                        open(settings.description);
                }
            }
            return false;
        });
    }
})(jQuery);
