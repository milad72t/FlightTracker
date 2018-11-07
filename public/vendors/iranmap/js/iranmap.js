/*
 * Iran Map - SVG and Responsive.
 * Free and open source.
 * Version 1.1.0
 * By: MohammadReza Pourmohammad.
 * Email: mohammadrpm@gmail.com
 * Web: http://mrpm.ir
 */

$(function() {

    $(window).resize(function() {
        resposive();
    });

    function resposive() {
        var height = $('#map').height();
        var width = $('#map').width() - ($('#map').width() / 10);
        if (height > width) {
            $('#IranMap svg').height(width).width(width);
        } else {
            $('#IranMap svg').height(height).width(height);
        }
    }
    resposive();

    $('#IranMap').ready(function() {
        $.each($('#IranMap .map .province path'), function (index, value) {
            for (var item in tozi_data) {

                var total = 0;
                if (tozi_data[item]['co_code'] == value.className.baseVal) {
                    total += tozi_data[item]['total'];

                    if (total > 100000000) {
                        $('.' + value.className.baseVal).css({fill: '#c1304f'});
                    }
                    else if (total < 100000000) {
                        $('.' + value.className.baseVal).css({fill: '#44dd65'});
                    }
                }
                if ((value.className.baseVal == "11" || value.className.baseVal == "21" ||value.className.baseVal == "41"
                    || value.className.baseVal == "51" ||value.className.baseVal == "61" ||value.className.baseVal == "111" ||value.className.baseVal == "121"
                    ||value.className.baseVal == "141") && parseInt(value.className.baseVal) + 1 == parseInt(tozi_data[item]['co_code'])) {

                    total += tozi_data[item]['total'];

                    if (total > 100000000) {
                        $('.' + value.className.baseVal).css({fill: '#c1304f'});
                    }
                    else if (total < 100000000) {
                        $('.' + value.className.baseVal).css({fill: '#44dd65'});
                    }
                }
            }
        });
    });

    $('#IranMap svg g path').hover(function() {
        var className = $(this).attr('class');
        var parrentClassName = $(this).parent('g').attr('class');
        var itemName = $('#IranMap .list .' + parrentClassName + ' .' + className + ' a').html();
        if (itemName) {
            var name;
            for (var item in tozi_data) {
                if (className == "11" || className == "21" || className == "41" || className == "51" || className == "61" || className == "111" || className == "121" || className == "141") {
                    var first_part;
                    var second_part;
                    for (var item2 in tozi_data) {
                        if (tozi_data[item2]['co_code'] == className) {
                            first_part = item2;
                        }
                        else if (parseInt(tozi_data[item2]['co_code']) == parseInt(className) + 1) {
                            second_part = item2;
                        }
                    }
                    // console.log(data[first_part])
                    // console.log(data[second_part])
                    if (second_part && first_part) {
                        name = tozi_data[first_part]['paramdesc'] + '- مجموع مصرف: ' + new Intl.NumberFormat().format(tozi_data[first_part]['total']) +' کیلووات' + '----' +
                            tozi_data[second_part]['paramdesc'] + '- مجموع مصرف: ' + new Intl.NumberFormat().format(tozi_data[second_part]['total']) +' کیلووات';
                    }
                    else if (first_part) {
                        name = tozi_data[first_part]['paramdesc'] + '- مجموع مصرف: ' + new Intl.NumberFormat().format(tozi_data[first_part]['total']) + ' کیلووات';
                    }
                    else if (second_part) {
                        name = tozi_data[second_part]['paramdesc'] + '- مجموع مصرف: ' + new Intl.NumberFormat().format(tozi_data[second_part]['total']) + ' کیلووات';
                    }
                }
                else {
                    if (className == tozi_data[item]['co_code']) {
                        name = tozi_data[item]['paramdesc'] + '- مجموع مصرف: ' + new Intl.NumberFormat().format(tozi_data[item]['total']) + ' کیلووات';
                    }

                }
                $('#IranMap .list .' + parrentClassName + ' .' + className + ' a').addClass('hover');
                $('#IranMap .show-title').html(name).css({'display': 'block'});

            }

        }
    }, function() {
        $('#IranMap .list a').removeClass('hover');
        $('#IranMap .show-title').html('').css({'display': 'none'});
    });

    // $('#IranMap .list ul li ul li a').hover(function() {
    //     var className = $(this).parent('li').attr('class');
    //     var parrentClassName = $(this).parent('li').parent('ul').parent('li').attr('class');
    //     var object = '#IranMap svg g.' + parrentClassName + ' path.' + className;
    //     var currentClass = $(object).attr('class');
    //     $(object).attr('class', currentClass + ' hover');
    // }, function() {
    //     var className = $(this).parent('li').attr('class');
    //     var parrentClassName = $(this).parent('li').parent('ul').parent('li').attr('class');
    //     var object = '#IranMap svg g.' + parrentClassName + ' path.' + className;
    //     var currentClass = $(object).attr('class');
    //     $(object).attr('class', currentClass.replace(' hover', ''));
    // });

    $('#IranMap').mousemove(function(e) {
        var posx = 0;
        var posy = 0;
        if (!e)
            var e = window.event;
        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        } else if (e.clientX || e.clientY) {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        if ($('#IranMap .show-title').html()) {
            var offset = $(this).offset();
            var x = (posx - offset.left + 25) + 'px';
            var y = (posy - offset.top - 5) + 'px';
            $('#IranMap .show-title').css({'left': x, 'top': y});
        }
    });

});