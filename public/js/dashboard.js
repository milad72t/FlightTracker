$(document).ready(function () {
    $('#cocode2').multiselect({
        dropRight: true,
        enableFiltering: true,
        includeSelectAllOption: true
    });
    $('#cocode3').multiselect({
        dropRight: true,
        enableFiltering: true,
        includeSelectAllOption: true
    });
});

setAmountPlot();
setUsagePlot();

$('#widget_button').on('click', function () {
    var el = $('#cocode2').val();
    var el2 = $('#cocode3').val();
    var final_el;
    if (el != null) {
        final_el = el;
        $('#subscribers_label').text('برق منطقه ای (های) ' + $("#cocode2 option:selected").text().split('برق منطقه اي'));
    }
    else {
        final_el = el2;
        $('#subscribers_label').text('توزیع (های) ' + $("#cocode3 option:selected").text().split('توزيع'));
    }

    $.ajax({
        url: '/api/getIdentityNumber/' + '?token=' + ssi,
        type: 'POST',
        dataType: "json",
        data:
            {
                'CoCodes': final_el
            },
        success: function (data) {
            cocodes = data.cocodes;
            $('#numbers').empty();
            var color_array = ['#36c9c2', '#7043a8', '#6fd626', '#d18017', '#724bf2', '#ff8263', '#c43131', '#3afbff', '#93bcff', '#6fd626', '#d18017', '#c43131', '#ff8263', '#ffc863'];

            $.each(data.data, function (index, element) {
                var sty = 'style="border: solid 2px' + color_array[index] + '; border-radius:10px; margin-left:7px; color:#fff; background-color: ' + color_array[index] + ';"';
                $('#numbers').append('<div class="col-md-2 col-sm-2 col-xs-6 tile_stats_count"' + sty + '><span class="count_top"><i class="fa fa-user" style="margin-left: 5px;"></i>' + element.paramdesc + '</span> <div class="count white">' + numeral(element.count).format() + '</div></div>');
            });
            $('#numbers').append('<div class="col-md-2 col-sm-2 col-xs-6 tile_stats_count" style="border: solid 2px #c43131 ; background-color:#c43131; color:#FFFFFF;  border-radius: 10px;"><span class="count_top white"><i class="fa fa-users" style="margin-left: 5px;"></i>مجموع مشترکین</span> <div class="count white" id="detail_subscribers" onclick="getDetail(cocodes)" style="cursor: pointer;">' + numeral(data.total).format() + '</div></div>');

        },
        error: function (data) {
            swal({
                title: 'سیستم پاسخ نمی دهد!',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
        },
        complete: function () {
        }
    });
    $.ajax({
        url: '/api/getAmountInPrevMonths/' + '?token=' + ssi,
        type: 'POST',
        dataType: "json",
        data:
            {
                'CoCodes': final_el
            },
        success: function (data) {
            data = data.data;
            var tks = [];// [index , 'tarikh']
            var ammounts = []; // [index , masraf]
            for (var i = 0; i < data.length; i++) {
                tks.push([i, data[i].date]);
                ammounts.push([i, data[i].total]);
            }
            var AmountChartData = ammounts;
            var AmountChartSettings = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function (label, series) {
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
                shadowSize: 0,
                tooltip: true,
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "null",
                    ticks: tks
                },
                zoom: {
                    interactive: true
                },
                pan: {
                    interactive: true
                }
            };
            $.plot($("#AmountsChart"),
                [{
                    label: "مبلغ",
                    data: AmountChartData,
                    lines: {
                        fillColor: "rgba(150, 202, 89, 0.12)"
                    },
                    points: {
                        fillColor: "#fff"
                    }
                }], AmountChartSettings);
            var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("تاریخ").appendTo($('#AmountsChart'));

            var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("میزان هزینه (ریال)").appendTo($('#AmountsChart'));
            yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
        },
        error: function (data) {
            swal({
                title: 'سیستم پاسخ نمی دهد!',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
        },
        complete: function () {
        }
    });
    $.ajax({
        url: '/api/getUsageInPrevMonths/' + '?token=' + ssi,
        type: 'POST',
        dataType: "json",
        data:
            {
                'CoCodes': final_el
            },
        success: function (data) {
            data = data.data;
            var tks = [];// [index , 'tarikh']
            var ammounts = []; // [index , masraf]
            for (var i = 0; i < data.length; i++) {
                tks.push([i, data[i].date]);
                ammounts.push([i, data[i].total]);
            }
            var UsageChartData = ammounts;
            var UsageChartSettings = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function (label, series) {
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
                shadowSize: 0,
                tooltip: true,
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "null",
                    ticks: tks
                },
                zoom: {
                    interactive: true
                },
                pan: {
                    interactive: true
                }
            };
            $.plot($("#UsageChart"), [{
                label: "نمودار مصرف (کیلووات ساعت)",
                data: UsageChartData,
                lines: {
                    fillColor: "rgba(150, 202, 89, 0.12)"
                },
                points: {
                    fillColor: "#fff"
                }
            }], UsageChartSettings);
            var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("تاریخ").appendTo($('#UsageChart'));

            var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("میزان مصرف (کیلووات ساعت)").appendTo($('#UsageChart'));
            yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
        },
        error: function (data) {
            swal({
                title: 'سیستم پاسخ نمی دهد!',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
        },
        complete: function () {
        }
    });
});

$('#widget_clear').on('click', function () {
    $("option:selected").removeAttr("selected");
    $('#subscribers_label').empty();
    $("#numbers").load(location.href + " #numbers");
    setAmountPlot();
    setUsagePlot();
    $("#cocode2 ,#cocode3").multiselect("deselectAll", false);
    $('#cocode2 ,#cocode3').multiselect('updateButtonText');
});

function getDetail(cocode) {
    var form = {
        'CoCodes': cocodes,
        'FromDateSh': '1350/01/01'
    };

    $.ajax({
        url: '/api/getReport143?token=' + ssi,
        type: 'POST',
        data: form,
        dataType: "json",
        timeout: 0, //Set your timeout value in milliseconds or 0 for unlimited
        success: function (data) {

            $('#show_modal').click();

            var response = '';
            $.each(data.total, function (index, value) {
                response = response.concat("<tr><td>" + index + "</td><td>" + data.decode[index] + "</td><td>" + numeral(value).format() + "</td></tr>");
            });

            var html = '<table id="datatable" class="table table-striped table-bordered"> <thead> <tr> <th>کد شرکت توزیع</th> <th>شرکت توزیع</th> <th> تعداد مشترک </th> </tr> </thead> <tbody>' + response + '</tbody>';
            document.getElementById('modal_content').innerHTML = html;
        },
        error: function (data) {
            swal({
                title: 'سیستم پاسخ نمی دهد!',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
        },
        complete: function () {
        }
    });
}

var formData = {
    'CoCodes': cocodes,
    'FromDateSh': '1350/01/01'
};
$('#detail_subscribers').on('click', function () {
    $.ajax({
        url: '/api/getReport143?token=' + ssi,
        type: 'POST',
        data: formData,
        dataType: "json",
        timeout: 0, //Set your timeout value in milliseconds or 0 for unlimited
        success: function (data) {
            $('#show_modal').click();
            var response = '';
            $.each(data.total, function (index, value) {
                response = response.concat("<tr><td>" + index + "</td><td>" + data.decode[index] + "</td><td>" + numeral(value).format() + "</td></tr>");
            });
            var html = '<table id="datatable" class="table table-striped table-bordered"> <thead> <tr> <th>کد شرکت توزیع</th> <th>شرکت توزیع</th> <th> تعداد مشترک </th> </tr> </thead> <tbody>' + response + '</tbody>';
            document.getElementById('modal_content').innerHTML = html;
        },
        error: function (data) {
            swal({
                title: 'سیستم پاسخ نمی دهد!',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
        },
        complete: function () {
        }
    });
});

$body = $("body");
$(document).on({
    ajaxStart: function () {
        $body.addClass("loading");
    },
    ajaxStop: function () {
        $body.removeClass("loading");
    }
});

function setAmountPlot() {
    if (typeof def_amount_data !== 'undefined') {
        document.getElementById('AmountsChart').style.pointerEvents = 'none';
        $("#amount_chart_click").on('click', function () {
            if (document.getElementById('AmountsChart').style.pointerEvents == 'none')
                document.getElementById('AmountsChart').style.pointerEvents = 'auto';
            else
                document.getElementById('AmountsChart').style.pointerEvents = 'none';
        });
        var def_data = def_amount_data.data;
        var def_tks = [];// [index , 'tarikh']
        var def_ammounts = []; // [index , masraf]
        for (var i = 0; i < def_data.length; i++) {
            def_tks.push([i, def_data[i].date]);
            def_ammounts.push([i, def_data[i].total]);
        }
        var AmountChartData = def_ammounts;
        var AmountChartSettings = {
            grid: {
                show: true,
                aboveData: true,
                color: "#3f3f3f",
                labelMargin: 10,
                axisMargin: 0,
                borderWidth: 0,
                borderColor: null,
                minBorderMargin: 5,
                clickable: true,
                hoverable: true,
                autoHighlight: true,
                mouseActiveRadius: 100
            },
            series: {
                lines: {
                    show: true,
                    fill: true,
                    lineWidth: 2,
                    steps: false
                },
                points: {
                    show: true,
                    radius: 4.5,
                    symbol: "circle",
                    lineWidth: 3.0
                }
            },
            legend: {
                position: "ne",
                margin: [0, -25],
                noColumns: 0,
                labelBoxBorderColor: null,
                labelFormatter: function (label, series) {
                    return label + '&nbsp;&nbsp;';
                },
                width: 40,
                height: 1
            },
            colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
            shadowSize: 0,
            tooltip: true,
            tooltipOpts: {
                content: "%s: %y.0",
                xDateFormat: "%d/%m",
                shifts: {
                    x: -30,
                    y: -50
                },
                defaultTheme: false
            },
            yaxis: {
                min: 0
            },
            xaxis: {
                mode: "null",
                ticks: def_tks
            },
            zoom: {
                interactive: true
            },
            pan: {
                interactive: true
            }
        };
        $.plot($("#AmountsChart"), [{
                label: "میزان هزینه",
                data: AmountChartData,
                lines: {
                    fillColor: "rgba(150, 202, 89, 0.12)"
                },
                points: {
                    fillColor: "#fff"
                },
            }], AmountChartSettings
        );

        var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("تاریخ").appendTo($('#AmountsChart'));

        var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("میزان هزینه (ریال)").appendTo($('#AmountsChart'));
        yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);

        $('#widget_button').on('click', function () {
            var el = $('#cocode2').val();
            var el2 = $('#cocode3').val();
            var final_el;
            if (el != null) {
                final_el = el;
                $('#subscribers_label').text('برق منطقه ای های ' + $("#cocode2 option:selected").text().split('برق منطقه اي'));
            }
            else {
                final_el = el2;
                $('#subscribers_label').text('توزیع های ' + $("#cocode3 option:selected").text().split('توزيع'));
            }
            $.ajax({
                url: '/api/getAmountInPrevMonths/' + '?token=' + ssi,
                type: 'POST',
                dataType: "json",
                data:
                    {
                        'CoCodes': final_el
                    },
                success: function (data) {
                    data = data.data;
                    var tks = [];// [index , 'tarikh']
                    var ammounts = []; // [index , masraf]
                    for (var i = 0; i < data.length; i++) {
                        tks.push([i, data[i].date]);
                        ammounts.push([i, data[i].total]);
                    }
                    var AmountChartData = ammounts;
                    var AmountChartSettings = {
                        grid: {
                            show: true,
                            aboveData: true,
                            color: "#3f3f3f",
                            labelMargin: 10,
                            axisMargin: 0,
                            borderWidth: 0,
                            borderColor: null,
                            minBorderMargin: 5,
                            clickable: true,
                            hoverable: true,
                            autoHighlight: true,
                            mouseActiveRadius: 100
                        },
                        series: {
                            lines: {
                                show: true,
                                fill: true,
                                lineWidth: 2,
                                steps: false
                            },
                            points: {
                                show: true,
                                radius: 4.5,
                                symbol: "circle",
                                lineWidth: 3.0
                            }
                        },
                        legend: {
                            position: "ne",
                            margin: [0, -25],
                            noColumns: 0,
                            labelBoxBorderColor: null,
                            labelFormatter: function (label, series) {
                                return label + '&nbsp;&nbsp;';
                            },
                            width: 40,
                            height: 1
                        },
                        colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
                        shadowSize: 0,
                        tooltip: true,
                        tooltipOpts: {
                            content: "%s: %y.0",
                            xDateFormat: "%d/%m",
                            shifts: {
                                x: -30,
                                y: -50
                            },
                            defaultTheme: false
                        },
                        yaxis: {
                            min: 0
                        },
                        xaxis: {
                            mode: "null",
                            ticks: tks
                        },
                        zoom: {
                            interactive: true
                        },
                        pan: {
                            interactive: true
                        }
                    };
                    $.plot($("#AmountsChart"),
                        [{
                            label: "مبلغ",
                            data: AmountChartData,
                            lines: {
                                fillColor: "rgba(150, 202, 89, 0.12)"
                            },
                            points: {
                                fillColor: "#fff"
                            }
                        }], AmountChartSettings);
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("تاریخ").appendTo($('#AmountsChart'));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("میزان هزینه (ریال)").appendTo($('#AmountsChart'));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                },
                error: function (data) {
                    swal({
                title: 'سیستم پاسخ نمی دهد!',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
                },
                complete: function () {
                }
            });
        });
    }
}

function setUsagePlot() {
    if (typeof def_usage_data !== 'undefined') {
        document.getElementById('UsageChart').style.pointerEvents = 'none';
        $("#user_chart_click").on('click', function () {
            if (document.getElementById('UsageChart').style.pointerEvents == 'none')
                document.getElementById('UsageChart').style.pointerEvents = 'auto';
            else
                document.getElementById('UsageChart').style.pointerEvents = 'none';
        });
        data = def_usage_data.data;
        var usage_tks = [];// [index , 'tarikh']
        var usage_ammounts = []; // [index , masraf];
        for (var i = 0; i < data.length; i++) {
            usage_tks.push([i, data[i].date]);
            usage_ammounts.push([i, data[i].total]);
        }
        var UsageChartData = usage_ammounts;

        var UsageChartSettings = {
            grid: {
                show: true,
                aboveData: true,
                color: "#3f3f3f",
                labelMargin: 10,
                axisMargin: 0,
                borderWidth: 0,
                borderColor: null,
                minBorderMargin: 5,
                clickable: true,
                hoverable: true,
                autoHighlight: true,
                mouseActiveRadius: 100
            },
            series: {
                lines: {
                    show: true,
                    fill: true,
                    lineWidth: 2,
                    steps: false
                },
                points: {
                    show: true,
                    radius: 4.5,
                    symbol: "circle",
                    lineWidth: 3.0
                }
            },
            legend: {
                position: "ne",
                margin: [0, -25],
                noColumns: 0,
                labelBoxBorderColor: null,
                labelFormatter: function (label, series) {
                    return label + '&nbsp;&nbsp;';
                },
                width: 40,
                height: 1
            },
            colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
            shadowSize: 0,
            tooltip: true,
            tooltipOpts: {
                content: "%s: %y.0",
                xDateFormat: "%d/%m",
                shifts: {
                    x: -30,
                    y: -50
                },
                defaultTheme: false
            },
            yaxis: {
                min: 0
            },
            xaxis: {
                mode: "null",
                ticks: usage_tks
            },
            zoom: {
                interactive: true
            },
            pan: {
                interactive: true
            }
        };
        $.plot($("#UsageChart"), [{
            label: "نمودار مصرف (برحسب کیلووات ساعت)",
            data: UsageChartData,
            lines: {
                fillColor: "rgba(150, 202, 89, 0.12)"
            },
            points: {
                fillColor: "#fff"
            }
        }], UsageChartSettings);
        var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("تاریخ").appendTo($('#UsageChart'));

        var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("میزان مصرف (کیلووات ساعت)").appendTo($('#UsageChart'));
        yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);

        $('#widget_button').on('click', function () {
            var el = $('#cocode2').val();
            var el2 = $('#cocode3').val();
            var final_el;
            if (el != null) {
                final_el = el;
                $('#subscribers_label').text('برق منطقه ای های ' + $("#cocode2 option:selected").text().split('برق منطقه اي'));
            }
            else {
                final_el = el2;
                $('#subscribers_label').text('توزیع های ' + $("#cocode3 option:selected").text().split('توزيع'));
            }
            $.ajax({
                url: '/api/getUsageInPrevMonths/' + '?token=' + ssi,
                type: 'POST',
                dataType: "json",
                data:
                    {
                        'CoCodes': final_el
                    },
                success: function (data) {
                    data = data.data;
                    var tks = [];// [index , 'tarikh']
                    var ammounts = []; // [index , masraf]
                    for (var i = 0; i < data.length; i++) {
                        tks.push([i, data[i].date]);
                        ammounts.push([i, data[i].total]);
                    }
                    var UsageChartData = ammounts;
                    var UsageChartSettings = {
                        grid: {
                            show: true,
                            aboveData: true,
                            color: "#3f3f3f",
                            labelMargin: 10,
                            axisMargin: 0,
                            borderWidth: 0,
                            borderColor: null,
                            minBorderMargin: 5,
                            clickable: true,
                            hoverable: true,
                            autoHighlight: true,
                            mouseActiveRadius: 100
                        },
                        series: {
                            lines: {
                                show: true,
                                fill: true,
                                lineWidth: 2,
                                steps: false
                            },
                            points: {
                                show: true,
                                radius: 4.5,
                                symbol: "circle",
                                lineWidth: 3.0
                            }
                        },
                        legend: {
                            position: "ne",
                            margin: [0, -25],
                            noColumns: 0,
                            labelBoxBorderColor: null,
                            labelFormatter: function (label, series) {
                                return label + '&nbsp;&nbsp;';
                            },
                            width: 40,
                            height: 1
                        },
                        colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
                        shadowSize: 0,
                        tooltip: true,
                        tooltipOpts: {
                            content: "%s: %y.0",
                            xDateFormat: "%d/%m",
                            shifts: {
                                x: -30,
                                y: -50
                            },
                            defaultTheme: false
                        },
                        yaxis: {
                            min: 0
                        },
                        xaxis: {
                            mode: "null",
                            ticks: tks
                        },
                        zoom: {
                            interactive: true
                        },
                        pan: {
                            interactive: true
                        }
                    };
                    $.plot($("#UsageChart"), [{
                        label: "نمودار مصرف (کیلووات ساعت)",
                        data: UsageChartData,
                        lines: {
                            fillColor: "rgba(150, 202, 89, 0.12)"
                        },
                        points: {
                            fillColor: "#fff"
                        }
                    }], UsageChartSettings);
                    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("تاریخ").appendTo($('#UsageChart'));

                    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("میزان مصرف (کیلووات ساعت)").appendTo($('#UsageChart'));
                    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
                },
                error: function (data) {
                    swal({
                title: 'سیستم پاسخ نمی دهد!',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
                },
                complete: function () {
                }
            });
        });
    }
}

if (typeof def_receipt !== 'undefined') {
    Morris.Bar({
        element: 'receipt_bar',
        data: def_receipt,
        xkey: 'paramdesc',
        ykeys: ['total'],
        labels: ['وصول'],
        barRatio: 0.4,
        xLabelAngle: 25,
        hideHover: 'auto',
        resize: true
    });
    var xaxisLabel = $("<div class='axisLabel xaxisLabel'></div>").text("تاریخ").appendTo($('#receipt_bar'));
    xaxisLabel.css("top", 290);
    var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>").text("میزان وصول (ریال)").appendTo($('#receipt_bar'));
    yaxisLabel.css("margin-top", yaxisLabel.width() / 2 - 20);
}