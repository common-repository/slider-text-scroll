jQuery(document).ready(function () {
    // Start marquee
    jQuery('.marquee_text').marquee({
        direction: estsObjAdmin.tDir,
        duration: parseInt(estsObjAdmin.tDur),
        gap: parseInt(estsObjAdmin.tGap),
        delayBeforeStart: 0,
        duplicated: false,
        startVisible: parseInt(estsObjAdmin.visi)
    });
    
    // Start Text slider
    jQuery('.hero_title').text(''); // document.querySelector('.hero_title').textContent = '';
    var typed = new Typed('.hero_title', {
        strings: JSON.parse(estsObjAdmin.stText), // estsObjAdmin.stText,
        typeSpeed: parseInt(estsObjAdmin.stTypeSpeed), // estsObjAdmin.stTypeSpeed,
        startDelay: parseInt(estsObjAdmin.stStartDelay),
        backSpeed: parseInt(estsObjAdmin.stBackSpeed),
        backDelay: parseInt(estsObjAdmin.stBackDelay),
        loop: estsObjAdmin.stLoop, // false,
        showCursor: true,
        cursorChar: '',
        autoInsertCss: false
    });

});


