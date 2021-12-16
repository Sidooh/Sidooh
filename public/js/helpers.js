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
