$(document).ready(function () {
    
    $(".ligne_table_liste_tache").mouseenter(function () {
        console.log("hover tr");
        $(this).find(".liste-taches-action-volatile").show(); //.show( "slow" );
    });

    $(".ligne_table_liste_tache").mouseleave(function () {
        console.log("out tr");
        $(this).find(".liste-taches-action-volatile").hide();
    });
    

});



