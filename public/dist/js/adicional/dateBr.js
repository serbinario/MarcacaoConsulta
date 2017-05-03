$.validator.addMethod("dateBr", function(value, element) {
    return this.optional(element) || /^[0-3]\d-[0-9]\d-[1-2]\d{3}$/i.test(value);
}, $.validator.messages.dateBr);