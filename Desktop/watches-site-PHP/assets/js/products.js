document.addEventListener("DOMContentLoaded",function () {
    var slider = document.getElementById('slider');
    noUiSlider.create(slider, {
        start: [slider.getAttribute("data-min"), slider.getAttribute("data-max")],
        connect: true,
        step: 1,
        range: {
            'min': parseInt(slider.getAttribute("data-min")),
            'max': parseInt(slider.getAttribute("data-max"))
        },
        format: wNumb({
            decimals: 0
        })
    });












});
