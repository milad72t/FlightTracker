Calendar.setup({
    inputField: 'departureTime',
    button: 'departureTime',
    ifFormat: '%Y/%m/%d',
    dateType: 'jalali'
});

$('input:text.number').keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
        // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
$('.date-picker').on('keydown', function (e) {
    e.preventDefault();
    return;
});

String.prototype.toEnDigit = function() {
    return this.replace(/[\u06F0-\u06F9]+/g, function(digit) {
        var ret = '';
        for (var i = 0, len = digit.length; i < len; i++) {
            ret += String.fromCharCode(digit.charCodeAt(i) - 1728);
        }

        return ret;
    });
};

$('input:text.number').on('input', function() {
    var value = $(this).val();
    $(this).val(value.toEnDigit());
});