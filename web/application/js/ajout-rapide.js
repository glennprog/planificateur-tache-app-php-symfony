$(document).ready(function () {

    function ajoutRapide()
    {
        var nouvelle_tache = $("#input_fonction_ajout_rapide_tache").val();
        if(nouvelle_tache.trim() == "")
        {
            $("#input_fonction_ajout_rapide_tache").val("");
            return;
        }
        nouvelleTache(nouvelle_tache.trim());
    }

    function nouvelleTache(nouvelle_tache) 
    {
        var description = nouvelle_tache;
        $.ajax({
            url: "http://planificateur-tache.com/app_dev.php/mes-taches/nouvelle-tache-json-full",
            method: "post",
            contentType: "application/json",
            data: JSON.stringify({ "nom": nouvelle_tache, "description": description })
        }).done(function (response) {
            if (response.reponseControle.codeStatus)
            {
               
                resultat = JSON.parse(response.reponseControle.resultat);
                tache_id_lien = "http://planificateur-tache.com/app_dev.php/mes-taches/consulter/tache/"+resultat.id;
                tr_element_liste_taches =
                (
                    "<tr>"
                    + "<td><a class='a-hover-highlited cursor-context-menu' href='"+tache_id_lien+"'>" + resultat.nom + "</a></td>"
                    + "<td>" + resultat.statut + "</td>"
                    + "<td>" + resultat.dateCreation.date.substring(0, 19) + "</td>"
                    + "<td class='td-ordre-tache'><span class='badge-ordre-tache'>" + resultat.ordre + "</span></td>" +
                    "</tr>"
                );
                $(tr_element_liste_taches).appendTo("#tbody_table_liste"); // Ajouter la ligne à la fin du tableau.
                $("#input_fonction_ajout_rapide_tache").val(""); // Nettoyer l'entrée.
            }
            else
            {
                console.log("Il y a eu un problème lors de la création de la tâche");
                alert("Il y a eu un problème lors de la création de la tâche");
            }

        }).fail(function (response) {
            console.log("error");
            console.log(response.responseJSON.reponseControle);
        });
    }

    $("#boutton_fonction_ajout_rapide_tache").click(function () {
        ajoutRapide();
    })

    $('#input_fonction_ajout_rapide_tache').keyup(function(e){
        if(e.which == 13){//Touche Entrée pressée
            ajoutRapide();
        }
        else
        {
            return;
        }
    });
});

