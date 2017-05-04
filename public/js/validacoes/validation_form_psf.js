$(document).ready(function () {
    $('#formPS').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'nome': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            }
        }
    });
});
