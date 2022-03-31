window.InitCountUp = (node, endVal, data = {}, roundWithSuffix = false) => {
    if(roundWithSuffix) {
        if(endVal > 999) {
            data.suffix = 'K'
            endVal /= 1000
        } else if(endVal > 999999) {
            data.suffix = 'M'
            endVal /= 1000000
        }
    }

    let countUp = new window.countUp.CountUp(node, endVal, {
        ...data,
        duration: 5
    });

    !countUp.error ? countUp.start() : console.error(countUp.error);
}

window.chartGradient = rgbColor => {
    let rgb = rgbColor.join()
    let gradient = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 400);

    gradient.addColorStop(0, `rgba(${rgb}, .7)`);
    gradient.addColorStop(1, `rgba(${rgb}, 0)`);

    return gradient;
}

window.toast = data => {
    const duration = (data.duration ?? 7) * 1000,    //  Converts to seconds
        type = data.type ?? 'success'

    Toastify({
        text: data.msg,
        duration: duration,
        close: true,
        position: data.position ?? 'right',
        className:type,
    }).showToast();
}

window.JWT = {
    decode: token => {
        let base64Url = token.split('.')[1];
        let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        let jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));

        return JSON.parse(jsonPayload);
    },
}
