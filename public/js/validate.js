const emailRegex = /^\s*[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z]+\.)?(gmail|yopmail|strathmore|googlemail|a)\.(a|com|org|edu|ac\.ke|net)\s*$/;

$.validator.setDefaults({
    errorClass: 'is-invalid text-danger',
    validClass: 'is-valid',
    errorElement: 'small',
});

$('#sign-in').validate({
    rules: {
        email: {
            pattern: emailRegex,
            required: true
        },
        password: 'required'
    },
    messages: {
        email: {
            required: 'Email address is required.',
            pattern: 'Invalid email address.',
        },
        password: 'Password is required.',
    },
    submitHandler: form => {
        const data = {};
        $(form).serializeArray().map(input => data[input.name] = input.value);

        const submitButton = $(form).find($('button[type="submit"]'));

        $.ajax({
            data: data,
            url: `/login`,
            method: 'POST',
            headers: {
                Accept: 'application/json'
            },
            dataType: 'json',
            beforeSend: () => submitButton.prop('disabled', false).html(`Signing In...
										<span class="ld ld-ring ld-spin"></span>`).addClass('running'),
            success: response => {
                if (response.status) {
                    location.href = response.url;
                } else if (response.message) {
                    toast({msg: response.message, type: 'warning', duration: 10, position: 'left'});
                } else {
                    toast({
                        msg: `Error: unable to sign you in. Kindly contact admin.`,
                        type: 'warning',
                        position: 'left'
                    });
                }
            },
            error: xhr => {
                let res = eval("(" + xhr.responseText + ")");

                if (res.errors) {
                    toast({msg: res.errors[Object.keys(res.errors)], type: 'warning', duration: 10});
                    submitButton.prop('disabled', false).html(`Sign In
										<span class="ld ld-ring ld-spin"></span>`).removeClass('running');
                }
            },
            complete: (xhr) => {
                let res = eval("(" + xhr.responseText + ")");

                if (res.status !== true) submitButton.prop('disabled', false).html(`Sign In
										<span class="ld ld-ring ld-spin"></span>`).removeClass('running');
            }
        });
    }
});
