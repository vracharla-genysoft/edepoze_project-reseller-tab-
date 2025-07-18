// polyfill
if (!window.hasOwnProperty("isset") || typeof window.isset !== "function")(function() {
    "use strict";
    /**
     * is set
     * @param {*} v
     * @returns {boolean}
     */
    function isset(v) {
        return (typeof v !== "undefined" && v !== null);
    }
    window.isset = isset;
})();