$(document).ready(function () {
    $('#formAgendados').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'especialista': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'especialidade': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'localidade': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'horario': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            }
        }
    });
});
