$("#nom").on("keyup", function() {

    $(this).val($(this).val().toUpperCase());
});

$("#prenom").on("keyup", function() {

    $(this).val($(this).val().charAt(0).toUpperCase() + $(this).val().substr(1).toLowerCase());

});

$("#reset").on("click", function() {
    $(".erreur").html("");


});
