$.validator.addMethod("alphaSpace", function(value, element) {
    return this.optional(element) || /^[A-Za-zÁ-Ùá-ù\s]+$/i.test(value);
}, $.validator.messages.alphaSpace);