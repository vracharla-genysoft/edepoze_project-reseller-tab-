function toggleCountry() {
    switch ($('.countryToggler').val()) {
        case 'CA':
            $('.usaAddress, .otherAddress').hide();
            $('.usaAddress input, .usaAddress select, .otherAddress input, .otherAddress select').prop("disabled", true);
            $('.canadaAddress').show();
            $('.canadaAddress input, .canadaAddress select').prop("disabled", false);
            break;
        case 'OT':
            $('.usaAddress, .canadaAddress').hide();
            $('.usaAddress input, .usaAddress select, .canadaAddress input, .canadaAddress select').prop("disabled", true);
            $('.otherAddress').show();
            $('.otherAddress input, .otherAddress select').prop("disabled", false);
            break;
        case 'US':
        default:
            $('.canadaAddress, .otherAddress').hide();
            $('.canadaAddress input, .canadaAddress select, .otherAddress input, .otherAddress select').prop("disabled", true);
            $('.usaAddress').show();
            $('.usaAddress input, .usaAddress select').prop("disabled", false);
            break;
    }
}