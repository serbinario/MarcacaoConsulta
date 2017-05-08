$(document).ready(function () {
    $('#formOperacao').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'grupo_operaco_id': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
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
