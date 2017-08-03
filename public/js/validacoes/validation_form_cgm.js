$(document).ready(function () {
    $('#formCGM').bootstrapValidator({
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
            },
            /*'data_nascimento': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'sexo_id': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'fone': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'cgm_municipio_id': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'cpf_cnpj': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'rg': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },*/
            'numero_sus': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            /*'numero_nis': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'endereco[logradouro]': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'endereco[numero]': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'estado': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'cidade': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            },
            'endereco[bairro_id]': {
                validators: {
                    notEmpty: {
                        message: "Este campo é obrigatório",
                    }
                }
            }*/
        }
    });
});
