/**
 * Created by maps_red on 31/01/17.
 */

$(document).ready(function () {
    $("#orderForm").submit(function (e) {
        e.preventDefault();
        var order = $("#order").find(":selected").val();
        var sort = $("#sort").find(":selected").val();
        window.location.href = Routing.generate("travel_list", {page: 1, sort: sort, order: order});

    })
});