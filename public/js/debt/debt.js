$(document).ready(function () {
    $(document).on('submit', '#form-debt', function (e) {
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

            $('#form-debt').hide('slow');
            msg.text(response.msg);
            msg.show('slow');
        });
    });

    $(document).on('click', '#debt_delete', function (e) {
        e.preventDefault();

        var response = confirm("Tem certeza que deseja remover esse registro?");
        if (response === true) {
            var debtId = $(this).data('id');
            request = $.ajax({
                type: "POST",
                url: 'delete',
                data: {id:debtId},
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

function formatValue() {
    var element = document.getElementById('amount');
    var value = element.value;

    value = value + '';
    value = parseInt(value.replace(/[\D]+/g, ''));
    value = value + '';
    value = value.replace(/([0-9]{2})$/g, ",$1");

    if (value.length > 6) {
        value = value.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    }

    element.value = value;
    if(value == 'NaN') element.value = '';
}

$('#due_date').mask('00/00/0000');
