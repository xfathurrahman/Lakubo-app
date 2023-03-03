$(document).ready(function() {
    const animationPromise = new Promise(function (resolve, reject) {
        const animation = lottie.loadAnimation({
            container: document.getElementById('loading-animation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: $('#loading-animation').data('animation-path')
        });
        animation.addEventListener('DOMLoaded', function () {
            resolve(animation);
        });
    });
    const backgroundPromise = new Promise(function (resolve, reject) {
        $(window).on('load', function () {
            setTimeout(function () {
                $('#loading-background').fadeOut('slow', function () {
                    resolve();
                });
            }, 2000);
        });
    });
    Promise.all([animationPromise, backgroundPromise]).then(function () {
        console.log('All elements are ready.');
    });
});
