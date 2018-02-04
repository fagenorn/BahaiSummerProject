let start_date = "2018-07-06";
let end_date = "2018-07-10";

$(document).ready(function () {
    let clicked = false;
    $("#submit").on("click", function (e) {
        e.preventDefault();
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
        return false;
    });

    function printErrorMsg(msg) {
        $(".print-error-msg").show();
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display', 'block');
        $.each(msg, function (key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }
});

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