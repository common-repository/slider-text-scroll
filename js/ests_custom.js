jQuery(document).ready(function () {
    // Start marquee
    jQuery('.marquee_text').marquee({
        direction: estsCustomData.tDir,
        duration: parseInt(estsCustomData.tDur),
        gap: parseInt(estsCustomData.tGap),
        delayBeforeStart: 0,
        duplicated: false,
        startVisible: parseInt(estsCustomData.visi)
    });
    
    // Start Text slider
    jQuery('.hero_title').text(''); // document.querySelector('.hero_title').textContent = '';
    var typed = new Typed('.hero_title', {
        strings: JSON.parse(estsCustomData.stText), // estsCustomData.stText,
        typeSpeed: parseInt(estsCustomData.stTypeSpeed), // estsCustomData.stTypeSpeed,
        startDelay: parseInt(estsCustomData.stStartDelay),
        backSpeed: parseInt(estsCustomData.stBackSpeed),
        backDelay: parseInt(estsCustomData.stBackDelay),
        loop: estsCustomData.stLoop, // false,
        showCursor: true,
        cursorChar: '',
        autoInsertCss: false
    });

});


