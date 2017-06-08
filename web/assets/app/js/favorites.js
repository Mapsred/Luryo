/**
 * Created by Maps_red on 10/03/2017.
 */

$(document).ready(function () {
    $("#favorite").click(function () {
        $(this).append("<i class=\"fa fa-spinner\" aria-hidden=\"true\"></i>");
        $.ajax({
            type: "POST",
            url: Routing.generate("favorite"),
            data: {
                id: $(this).data("id"),
                action: $(this).data("action")
            },
            success: function () {
                var favorite = $("#favorite");
                $("i.fa.fa-spinner").remove();
                if (favorite.data("action") === "remove") {
                    favorite.data("action", "add");
                    favorite.html('<i class="fa fa-heart-o" aria-hidden="true"></i> Retiré des favoris');
                } else {
                    favorite.data("action", "remove");
                    favorite.html('<i class="fa fa-heart" aria-hidden="true"></i> Ajouté aux favoris');
                }
            }
        });

    });

    initMap();
});


function initMap() {
    if ($("#map").length !== "undefined") {
        var splitted = $("#map").data("coords").split("|");

        var coords = {lat: parseFloat(splitted[0]), lng: parseFloat(splitted[1])};
        new google.maps.Marker({
            position: coords, title: $("#map").data("title"),
            map: new google.maps.Map(document.getElementById('map'), {zoom: 15, center: coords})
        });

    }
}

