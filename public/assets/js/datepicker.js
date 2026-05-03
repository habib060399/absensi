$(function () {
    "use strict";

    if ($("#datePickerExample").length) {
        var date = new Date();
        var today = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
        );
        $("#datePickerExample").datepicker({
            format: "mm/yyyy",
            startView: "months",
            minViewMode: "months",
            todayHighlight: true,
            autoclose: true,
        });
        $("#datePickerExample").datepicker("setDate", today);
    }
    if ($("#datePickerExample2").length) {
        var date = new Date();
        var today = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
        );
        $("#datePickerExample2").datepicker({
            format: "mm/yyyy",
            startView: "months",
            minViewMode: "months",
            todayHighlight: true,
            autoclose: true,
        });
        $("#datePickerExample2").datepicker("setDate", today);
    }
    if ($("#datePickerExample3").length) {
        var date = new Date();
        var today = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
        );
        $("#datePickerExample3").datepicker({
            format: "mm/dd/yyyy",
            autoclose: true,
        });
    }
    if ($("#awal_ajaran").length) {
        var date = new Date();
        var today = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
        );
        $("#awal_ajaran").datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true,
        });
    }
    if ($("#akhir_ajaran").length) {
        var date = new Date();
        var today = new Date(
            date.getFullYear(),
            date.getMonth(),
            date.getDate()
        );
        $("#akhir_ajaran").datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true,
        });
    }
});

$('#datePickerMulai').datepicker({    
    format: "yyyy-mm-dd",
    todayHighlight: true,
});

$('#datePickerSelesai').datepicker({    
    format: "yyyy-mm-dd",
    todayHighlight: true,
});
// $('#datePickerMulai').on('changeDate', function() {    
//     tgl_mulai = $('#datePickerMulai').datepicker('getDate')            
//     var d = new Date(tgl_mulai);
//     date = ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0"+d.getDate()).slice(-2)+ "-" + d.getFullYear();
//     console.log(date);
//     return date;
    

// });    