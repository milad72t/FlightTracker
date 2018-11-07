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
$("#tab2").on('click', function () {
    console.log($('#bill_id').val().toEnglishDigits())
    $.ajax({
        url:'/api/getReceiptOfBillId/'+ $('#bill_id').val().toEnglishDigits() + '?token=' + ssi,
        type:'GET',
        data:formData,
        dataType: "json" ,
        timeout: 0, //Set your timeout value in milliseconds or 0 for unlimited
        success:function(data){
            if(data.stat == "success") {
                $.each(data.data, function (index, element)
                {
                    $("#modalSaleData").append('<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>')
                });
                $('#info6').dataTable({
                    destroy:true ,
                    paging: false,
                    searching : false,
                    info: false,
                    dom: 'Blfrtip',
                    "scrollX": true
                });
            }
            else
            {
                document.getElementById('modalSaleData').innerHTML = data.message;
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
});


$('#info1, #info2, #info3, #info4, #info5, #info8, #info9, #info10').dataTable({
    destroy:true ,
    paging: false,
    searching : false,
    info: false,
    "scrollX": true
});
