/**
 * Created by Maps_red on 10/03/2017.
 */

$(document).ready(function () {
    $("#favorite").click(function () {
        $.ajax({
            type: "POST",
            url: Routing.generate("favorite"),
            data: {
                id: $(this).data("id"),
                action: $(this).data("action")
            },
            success: function () {
                var favorite = $("#favorite");
                if (favorite.data("action") === "remove") {
                    favorite.data("action", "add");
                    favorite.html('<i class="fa fa-heart-o" aria-hidden="true"></i> Retirer aux favoris');
                }else {
                    favorite.data("action", "remove");
                    favorite.html('<i class="fa fa-heart" aria-hidden="true"></i> Ajouter aux favoris');
                }
            }
        });

    })
});