let start_date = "07/06/2018";
let end_date = "07/10/2018";

initializeDates = function () {
    $("[rel=tooltip]").tooltip({html:true});
    $('input[type="daterange-single-dob"]').each(function () {
        if (!this.value) $(this).daterangepicker({
            "forceParse": false,
            "singleDatePicker": true,
            "showDropdowns": true,
        });
    });

    $('input[type="daterange-single-stay"]').each(function () {
        if (!this.value) $(this).daterangepicker({
            "forceParse": false,
            "singleDatePicker": true,
            "showDropdowns": true,
            "startDate": start_date,
            "endDate": end_date,
            "minDate": start_date,
            "maxDate": end_date
        });
    });
};