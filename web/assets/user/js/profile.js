/**
 * Created by maps_red on 01/02/17.
 */
$(document).ready(function () {
    $('#profile_form_birthday').datepicker({
        format: "dd/mm/yyyy",
        startDate: "01/01/1950",
        endDate: "today",
        language: "fr",
        autoclose: true,
        defaultViewDate: {year: 1996, month: 0, day: 1}
    });

    $("#profile_form_interests").select2();

    if (typeof $("#default-city") !== "undefined") {
        var city = $("#default-city").html().split("|");
        $("#default-city").remove();

        $("#profile_form_address_city").append("<option value='"+city[0]+"'>"+city[1]+"</option>");
    }

    $("#profile_form_address_city").select2({
        ajax: {
            url: Routing.generate("ajax_cities"),
            data: function (params) {
                return {search: params.term};
            },
            processResults: function (data) {
                return {results: data};
            }
        }
    });
});