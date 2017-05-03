$.validator.addMethod("chaveJ", function(value, element) {
    return this.optional(element) || /^[J][0-9]{7}$/i.test(value);
}, $.validator.messages.chaveJ);
