var subscData;
String.prototype.toEnglishDigits = function () {
    var num_dic = {
        '۰': '0',
        '۱': '1',
        '۲': '2',
        '۳': '3',
        '۴': '4',
        '۵': '5',
        '۶': '6',
        '۷': '7',
        '۸': '8',
        '۹': '9',
    }

    return parseInt(this.replace(/[۰-۹]/g, function (w) {
        return num_dic[w]
    }));
}
$("#form_submit").on('click', function (e) {
    e.preventDefault();
    $('#subsDate').empty();
    if ($('#bill_id').val() != "") {
        $.ajax({
            url: '/api/getCreditTimesByBillId/' + $('#bill_id').val().toEnglishDigits() + '?token=' + ssi,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.status == 'success') {
                    if (data.data.length != 0) {
                        if (data.data.length == 1) {
                            $('#subsDate').append('<div class="col-md-4 col-sm-4 col-xs-12" style="display: none;"><input type="radio" checked="" value="' + data.data[0] + '" id="radio1" name="date" style="margin-top: 10px;"><span style="margin-right: 5px;"></span></div>');
                            $("#form_submit2").click();
                        }
                        else {
                            $('#subsDate').append('<label class="control-label col-md-1 col-sm-1 col-xs-2" for="roles"> تاریخ </label>');
                            $.each(data.data, function (index, element) {
                                $('#subsDate').append('<div class="col-md-2 col-sm-2 col-xs-12"><input type="radio" checked="" value="' + element + '" id="radio1" name="date" style="margin-top: 10px;"><span style="margin-right: 5px;">' + element + '</span></div>');
                            });
                            document.getElementById('subsDate').style.display = "";
                            document.getElementById('form_submit2').style.display = "";
                        }

                    }
                    else {
                        document.getElementById('subsDate').style.display = "none";
                        document.getElementById('form_submit2').style.display = "none";
                        swal({
                            title: 'لطفا یک شناسه قبض صحیح وارد کنید',
                            type: 'error',
                            background: '#fff url(//bit.ly/1Nqn9HU)',
                            confirmButtonText: 'بستن'
                        });
                    }
                }
                else {
                    swal({
                        title: data.message,
                        type: 'error',
                        background: '#fff url(//bit.ly/1Nqn9HU)',
                        confirmButtonText: 'بستن'
                    });
                }
            },
            error: function (data) {
                console.log("error");
                console.log(data);
                $('#modalData').append('خطا در سیستم');
            }
        });
    }
    else {
        swal({
            title: 'لطفا یک شناسه قبض صحیح وارد کنید',
            type: 'error',
            background: '#fff url(//bit.ly/1Nqn9HU)',
            confirmButtonText: 'بستن'
        });
    }
});

$('#datatable').DataTable({
    destroy: true,
    dom: 'Blfrtip',
    buttons: [
        'csv', 'print'
    ]
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

var SubscriberForm = $("#subscriberForm");
$("#form_submit2").on('click', function (e) {
    e.preventDefault();
    var formData = SubscriberForm.serializeArray();
    formData[0]['value'] = formData[0]['value'].toEnglishDigits();
    $.ajax({
        url: '/subscriberInfo',
        type: 'POST',
        data: formData,
        dataType: "json",
        timeout: 0, //Set your timeout value in milliseconds or 0 for unlimited
        success: function (data) {
            if (data.stat == "success") {
                document.getElementById('ReportResult').style.display = "";
                document.getElementById('ReportResult').innerHTML = data.html;
                subscData = data.info;
                $('#datatable').DataTable({
                    destroy: true,
                    "bPaginate": false,
                    dom: 'Blfrtip',
                    buttons: [
                        'csv', 'print'
                    ]
                });
                $('#datatable2').DataTable({
                    dom: 'Blfrtip',
                    buttons: [
                        'csv', 'print'
                    ]
                });
                event = jQuery.Event("keypress");
                event.which = 13;
                $('input.input-sm').on('keyup', function (e) {
                    if (e.keyCode >= 48 && e.keyCode <= 57) {
                        var value = $(this).val();
                        value = $(this).val(value.toEnglishDigits());
                        console.log(value.val());
                    }
                }).trigger(event);
                $("#tab2").on('click', function () {
                    if ($("#correct").children().length == 0 && $("#false").children().length == 0) {
                        $.ajax({
                            url: '/api/getSaleDataOfBillId/' + $('#bill_id').val().toEnglishDigits() + '?token=' + ssi,
                            type: 'GET',
                            dataType: "json",
                            timeout: 0, //Set your timeout value in milliseconds or 0 for unlimited
                            success: function (data) {

                                if (data.status == "success") {
                                    $.each(data.data, function (index, element) {
                                        var date1 =JSON.stringify(element.prev_reading_date).trim().replace(' ','/');
                                        var date2 =JSON.stringify(element.curr_reading_date).trim().replace(' ','/');
                                        // var date2 = JSON.stringify(element.curr_reading_date);
                                        $("#correct").append('<tr><td>' + element.total_active_usage + '</td><td>' + element.cold_days + '</td><td>' + element.warm_days + '</td><td>' + element.power_paytoll_amt + '</td><td>' + element.cold_usage_step + '</td><td>' + element.warm_usage_step + '</td><td>' + element.net_amt + '</td><td>' + element.tax_amt + '</td><td>' + element.paytoll_amt + '</td><td>' + element.gross_amt + '</td><td>' + element.react_usage + '</td><td>' + element.prev_reading_date + '</td><td>' + element.curr_reading_date + '</td><td>' + element.a1_amount + '</td><td>' + element.a2_amount + '</td><td>' + element.a3_amount + '</td><td>' + element.a4_amount + '</td><td>' + element.a1_usage + '</td><td>' + element.a2_usage+ '</td><td>' + element.a3_usage + '</td><td>' + element.a4_usage + '</td><td>' + '<button class="btn btn-warning" onclick=\'manualCalc('+element.a1_usage+','+element.a2_usage+','+element.a3_usage+','+element.a4_usage+','+ date1 +','+  date2  +')\'>محاسبه مجدد</button> ' + '</td>');
                                    });

                                    $.each(data.data1, function (index, element) {
                                        $("#false").append('<tr><td>' + element.total_active_usage + '</td><td>' + element.cold_days + '</td><td>' + element.warm_days + '</td><td>' + element.power_paytoll_amt + '</td><td>' + element.cold_usage_step + '</td><td>' + element.warm_usage_step + '</td><td>' + element.net_amt + '</td><td>' + element.tax_amt + '</td><td>' + element.paytoll_amt + '</td><td>' + element.gross_amt + '</td><td>' + element.react_usage + '</td><td>' + element.prev_reading_date + '</td><td>' + element.curr_reading_date + '</td><td>' + element.a1_amount + '</td><td>' + element.a2_amount + '</td><td>' + element.a3_amount + '</td><td>' + element.a4_amount + '</td><td>' + element.a1_usage + '</td><td>' + element.a2_usage+ '</td><td>' + element.a3_usage + '</td><td>' + element.a4_usage + '</td><td>' +'<button class="btn btn-warning" onclick="manualCalc('+element.a1_usage+','+element.a2_usage+','+element.a3_usage+','+element.a4_usage+','+element.prev_reading_date +','+element.curr_reading_date +')">محاسبه مجدد</button> ' + '</td>');
                                    });

                                    $('#info6, #info7, #info11').DataTable({
                                        destroy: true,
                                        "bPaginate": false,
                                        dom: 'Blfrtip',
                                        buttons: [
                                            'csv', 'print'
                                        ],
                                        "scrollX": true
                                    });

                                    $('html, body').animate({
                                        scrollTop: $("#branch").offset().top
                                    }, 900);
                                }
                                else {
                                    document.getElementById('modalRcptData').innerHTML = data.message;
                                }
                                return true;

                            },
                            error: function (data) {
                                console.log("error");
                                console.log(data);
                                swal({
                                    title: 'خطا در سیستم',
                                    type: 'error',
                                    background: '#fff url(//bit.ly/1Nqn9HU)',
                                    confirmButtonText: 'بستن'
                                });
                            },
                            complete: function () {
                                $('#loading-image').hide();
                            }
                        });
                    }

                });
                $("#tab3").on('click', function () {
                    if ($("#modalRcptData").children().length == 0) {
                        $.ajax({
                            url: '/api/getReceiptOfBillId/' + $('#bill_id').val().toEnglishDigits() + '?token=' + ssi,
                            type: 'GET',
                            dataType: "json",
                            timeout: 0, //Set your timeout value in milliseconds or 0 for unlimited
                            success: function (data) {

                                if (data.status == "success") {
                                    $.each(data.data, function (index, element) {
                                        $("#modalRcptData").append('<tr><td>' + element.payment_id + '</td><td>' + element.payment_amount + '</td><td>' + element.payment_method_fk + '</td><td>' + element.channel_type_fk + '</td><td>' + element.payment_date + '</td><td>' + element.tracking_number + '</td>');
                                    });

                                    $('#info5').DataTable({
                                        destroy: true,
                                        "bPaginate": false,
                                        dom: 'Blfrtip',
                                        buttons: [
                                            'csv', 'print'
                                        ],
                                        "scrollX": true
                                    });

                                    $('html, body').animate({
                                        scrollTop: $("#branch").offset().top
                                    }, 900);
                                }
                                else {
                                    document.getElementById('modalRcptData').innerHTML = data.message;
                                }

                                return true;

                            },
                            error: function (data) {
                                console.log("error");
                                console.log(data);
                                swal({
                                    title: 'خطا در سیستم',
                                    type: 'error',
                                    background: '#fff url(//bit.ly/1Nqn9HU)',
                                    confirmButtonText: 'بستن'
                                });
                            },
                            complete: function () {
                                $('#loading-image').hide();
                            }
                        });
                    }

                });

            }
            else {
                document.getElementById('ReportResult').style.display = "";
                document.getElementById('ReportResult').innerHTML = data.message;
            }

        },
        error: function (data) {
            console.log("error");
            console.log(data);
            swal({
                title: 'خطا در سیستم',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
        },
        complete: function () {
            $('#loading-image').hide();
        }
    });
});


$('input:text.number_input').keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
        // Allow: Ctrl+A, Command+A
        ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
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

function manualCalc(a1_usage , a2_usage , a3_usage , a4_usage , prev_reading_date , curr_reading_date) {
    // console.log("inputs are : " , a1_usage , a2_usage , a3_usage , a4_usage , prev_reading_date , curr_reading_date);
    document.getElementById('feeCalcResult').style.display = "";
    document.getElementById('feeCalcResult').innerHTML = "";

    // prev_reading_date = prev_reading_date.trim();
    // curr_reading_date = curr_reading_date.trim();
    // prev_reading_date = prev_reading_date.replace(" " ,"/");
    // curr_reading_date = curr_reading_date.replace(" " ,"/");
    $.ajax({
        url:'/calculation/fee',
        type:'POST',
        data:{
            '_token' : csrf_token ,
            'Trfhcode' : subscData.tariff_header,
            'trfcode' : subscData.tariff_fk_code ,
            'phs' : subscData.no_of_phase ,
            'amp' : subscData.amper ,
            'pwrcnt' : subscData.agreement_demand ,
            'fmlcode' : subscData.population_number ,
            'selcode' : '' ,
            'citycode' : subscData.region_code_main ,
            'datestart' : prev_reading_date ,
            'dateend' : curr_reading_date ,
            'cntrdgt' : subscData.digit_number,
            'cntrcoef' : subscData.adjustment_factor,
            'timercode' : subscData.reading_clock_code,
            'calcode' : '3' ,
            'a1pkw' : '0' ,
            'a2pkw' : '0' ,
            'a3pkw' : '0' ,
            'a4pkw' : '0' ,
            'a1nkw' : a1_usage ,
            'a2nkw' : a2_usage ,
            'a3nkw' : a3_usage ,
            'a4nkw' : a4_usage ,
            'r1pkw' : 0 ,
            'r1nkw' : 0 // specify!
        },
        dataType: "json" ,
        timeout: 0, //Set your timeout value in milliseconds or 0 for unlimited
        success:function(data){
            console.log(data);
            {
                if(data.stat == "success") {
                    document.getElementById('feeCalcResult').style.display = "";
                    document.getElementById('feeCalcResult').innerHTML = "";
                    document.getElementById('feeCalcResult').innerHTML = data.html;
                    $('.table').persiaNumber();
                    $('#datatable').dataTable({
                        destroy:true ,
                        pageLength: 25,
                        paging: true,
                        searching : true,
                        info: false,
                        dom: 'Blfrtip',
                        buttons: [
                            'csv' , {extend: 'print', title: function(){return data.title;}, customize: function(win) { $(win.document.body).find( 'table' ).css('font-size', '11px');}}
                        ],
                        "scrollX": true
                    });
                    $('html, body').animate({
                        scrollTop: $("#feeCalcResult").offset().top
                    }, 900);

                    String.prototype.toEnDigit = function() {
                        return this.replace(/[\u06F0-\u06F9]+/g, function(digit) {
                            var ret = '';
                            for (var i = 0, len = digit.length; i < len; i++) {
                                ret += String.fromCharCode(digit.charCodeAt(i) - 1728);
                            }

                            return ret;
                        });
                    };

                    event = jQuery.Event("keypress");
                    event.which = 13;
                    $('input.input-sm').on('keyup', function (e) {
                        if (e.keyCode >= 48 && e.keyCode <= 57) {
                            var value = $(this).val();
                            value = $(this).val(value.toEnDigit());
                            console.log(value.val());

                        }

                    }).trigger(event);
                }
                else
                {
                    document.getElementById('feeCalcResult').style.display = "";
                    document.getElementById('feeCalcResult').innerHTML = '<div class="alert alert-danger">' + data.message+ '</div>';
                }
            }
        },
        error: function (data) {
            console.log("error");
            console.log(data);
            swal({
                title: 'خطا در سیستم',
                type: 'error',
                background: '#fff url(//bit.ly/1Nqn9HU)',
                confirmButtonText: 'بستن'
            });
        },
        complete: function(){
            $('#loading-image').hide();
        }
    });
}


