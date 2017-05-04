$.validator.addMethod("bankBr", function(value, element) {
    return this.optional(element) || /^[0-9]+[-]?[0-9]+$/i.test(value);
}, $.validator.messages.bankBr);