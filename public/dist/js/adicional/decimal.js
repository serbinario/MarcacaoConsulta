$.validator.addMethod("decimal", function(value, element) {
    return this.optional(element) || /^\d*\,*[0-9]{2}$/i.test(value);
}, $.validator.messages.decimal);