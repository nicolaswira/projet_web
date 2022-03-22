$(document).ready(function(){
    $("#li_gestion_entreprises").delay(2000).addClass("hover");

    $(".button_edit_company").click(function() {
        $(".modal").show();
        $(".info_message").css("display", "none");
    });

    $(".close:eq(0)").click(function() {
        $(".modal").hide();
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById("modal_edit_company")) {
            $(".modal").hide();
        }
    }

    //MODAL POST CHECK
    var input = $('.input_edit_company');
    $('.form_edit_company').on('submit',(function(){
        $.post(
            '/Edit_company.php',
            {
                new_name_company: input[0].val().trim(),
                new_activity_sector_company: input[0].val().trim(),
                new_nb_internship_cesi_company: input[0].val().trim(),
                new_visibility_company: input[0].val().trim()},
            

                function(data, status, jqXHR) {
                    $(".info_message").html("Entreprise modifiée avec succès");
                    $(".info_message").css("background-color", "#90ee90");
                    $(".info_message").css("display", "block");

                    setTimeout(function() { $(".info_message").css("display", "none"); }, 4000);
            })    
        return false;
    }));
});