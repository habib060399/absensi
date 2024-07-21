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
            format: "mm/dd/yyyy",
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
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true,
        });
        $("#datePickerExample2").datepicker("setDate", today);
    }
});
