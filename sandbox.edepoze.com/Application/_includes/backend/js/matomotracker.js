/*Matomo Integration*/
var _paq = window._paq = window._paq || [];
(function() {
    $.ajax({
        async: false,
        // CHANGED: Corrected URL to absolute path from web server's EDEPOZE_PROJECT root
        url: '/EDEPOZE_PROJECT/sandbox.edepoze.com/Application/_includes/backend/js/matomo_config.php',
        datatype: "json",
        crossDomain: true,
        success: function(matomositeid_json) {
            var u = "https://techops-analytics.transperfect.com/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', JSON.parse(matomositeid_json)]);
            var d = document,
                g = d.createElement('script'),
                s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        },
        error: function(error) {
            alert('error; ' + eval(error.object));
        }
    })
})();
