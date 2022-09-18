$(document).ready(function () {

    $(document).on('submit', '#form-debtor', function (e) {
        e.preventDefault();

        var form = $(this);
        var msg = $('#status-msg');
        var url = form.attr('action');

        request = $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            dataType: "json"
        });

        request.done(function (response) {
            if (response.status) {
                msg.removeClass('msg-error');
                msg.addClass('msg-success');
                setTimeout(function () {
                    window.location.replace(response.path);
                }, 4000);
            } else {
                msg.removeClass('msg-success');
                msg.addClass('msg-error');
                setTimeout(function () {
                    window.location.replace(response.path);
                }, 4000);
            }

            $('#form-debtor').hide('slow');
            msg.text(response.msg);
            msg.show('slow');
        });
    });

    $(document).on('click', '#debtor_delete', function (e) {
        e.preventDefault();

        var response = confirm("Tem certeza que deseja remover esse registro?");
        if (response === true) {
            var debtorId = $(this).data('id');
            request = $.ajax({
                type: "POST",
                url: 'delete',
                data: {id:debtorId},
                dataType: "json"
            });

            request.done(function (response) {
                window.location.replace("list");
            });
        }
    });
});

(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

var options = {
    onKeyPress: function (cpf, ev, el, op) {
        var masks = ['000.000.000-000', '00.000.000/0000-00'],
            mask = (cpf.length > 14) ? masks[1] : masks[0];
        el.mask(mask, op);
    }
}

$('#cpf_cnpj').mask('000.000.000-000', options);
$('#phone_number').mask('(00) 0 0000-0000');
$('#birthdate').mask('00/00/0000');
$('#zipcode').mask('00000-000');

