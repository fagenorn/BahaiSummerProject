let start_date = "2018-07-06";
let end_date = "2018-07-10";

initializeDates = function () {
    $("[rel=tooltip]").tooltip({html: true});
    $('input[type="daterange-single-dob"]').each(function () {
        if (!this.value) $(this).daterangepicker({
            "locale": {
                "format": "YYYY-MM-DD",
            },
            "forceParse": false,
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoUpdateInput": false
        });
    });

    $('input[type="daterange-single-stay"]').each(function () {
        if (!this.value) $(this).daterangepicker({
            "locale": {
                "format": "YYYY-MM-DD",
            },
            "forceParse": false,
            "singleDatePicker": true,
            "showDropdowns": true,
            "startDate": start_date,
            "endDate": end_date,
            "minDate": start_date,
            "maxDate": end_date,
            "autoUpdateInput": false

        });
    });
};