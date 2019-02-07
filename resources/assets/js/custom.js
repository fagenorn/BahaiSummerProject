let start_date = "2019-07-06";
let end_date = "2019-07-10";
let clicked = false;
$(document).on("click", "#submit", function (e) {
    e.preventDefault();
    e.stopPropagation();
    if (!clicked) {
        clicked = true;
        let data = $(".form").serialize();
        $.ajax({
            url: "/register",
            type: 'POST',
            data: data,
            success: function (data) {
                if (!$.isEmptyObject(data.error)) {
                    printErrorMsg(data.error);
                    window.scrollTo(0, 0);
                    clicked = false;
                } else {
                    window.location.href = "success";
                }
            }
        });
    }
});

function printErrorMsg(msg) {
    $(".print-error-msg").show();
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}

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
            "minDate": "1900-01-01",
            "maxDate": end_date,
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
        });
    });
};