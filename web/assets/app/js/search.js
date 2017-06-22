/**
 * Created by maps_red on 02/02/17.
 */
$(document).ready(function () {
    if ($("#search_form").length > 0) {
        $('#search_form_date').datepicker({
            format: "dd/mm/yyyy",
            language: "fr",
            autoclose: true,
            startDate: "+0d"
        });

        $("#search_form_city").select2({
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
    }

    $("#orderForm").submit(function (e) {
        e.preventDefault();
        var parameters = getParams();
        parameters["search%5Dorder%5D"] = $("#order").find(":selected").val();
        parameters["search%5Dsort%5D"] = $("#sort").find(":selected").val();
        $.each(parameters, function (key, value) {
            if (value.length === 0) {
                delete parameters[key]
            }
        });

        window.location.href = Routing.generate("search", parameters);
    });
});

function getParams(param, as_array) {
    var vars = {};
    window.location.href.replace(location.hash, '').replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function (m, key, value) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if (param) {
        return vars[param] ? vars[param] : null;
    }
    if (typeof as_array === true) {
        return formated(vars);
    }

    return vars;
}

function formated(params) {
    var obj = [];
    $.each(params, function (key, value) {
        key = key.replace("%5D", "").split("%5B");
        if (typeof obj[key[0]] === "undefined") {
            obj[key[0]] = [];
        }

        obj[key[0]][key[1]] = value;
    });

    return obj;
}
