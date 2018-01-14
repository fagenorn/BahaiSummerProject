let start_date = "01/14/2018";
let end_date = "01/20/2018";

initializeDates = function () {
    $('input[type="daterange-single"]').each(function () {
        if (!this.value) $(this).daterangepicker({
            "forceParse": false,
            "singleDatePicker": true,
            "showDropdowns": true,
        });
    });

    $('input[type="daterange-stay"]').each(function () {
        if (!this.value) $(this).daterangepicker({
            "forceParse": false,
            "autoApply": true,
            "ranges": {
                "Full Stay": [
                    start_date,
                    end_date
                ]
            },
            "startDate": start_date,
            "endDate": end_date,
            "minDate": start_date,
            "maxDate": end_date,
            "drops": "up"
        }, function (start, end) {
            if (start.format('MM/DD/YYYY') !== start_date || end.format('MM/DD/YYYY') !== end_date) {
                $('.stay-meals').slideDown();
            } else {
                $('.stay-meals').slideUp();
            }
        });
    });
};