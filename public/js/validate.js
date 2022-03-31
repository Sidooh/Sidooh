const emailRegex = /^\s*[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z]+\.)?(gmail|yopmail|strathmore|googlemail|a)\.(a|com|org|edu|ac\.ke|net)\s*$/;

$.validator.setDefaults({
    errorClass: 'is-invalid text-danger',
    validClass: 'is-valid',
    errorElement: 'small',
});


