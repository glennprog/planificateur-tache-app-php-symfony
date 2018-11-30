<?php 

namespace AppBundle\Service;

class Serialiseur
{

    public function __construct()
    {
        
    }

    public function normaliseur($objet)
    {
        $objet_normalise = array();
        $methodes = get_class_methods($objet); // Récupère touts les méthodes de l'objet à normaliser.
        foreach ($methodes as $methode)
        {
            if(substr_compare($methode, 'get',0,2) == 0) // Recherche toutes les méthodes "getters".
            {
                $determineKey = lcfirst(substr($methode,3)); // Supprime "get" et met le 1er caractère en minuscule.
                $res = call_user_func(array($objet, $methode)); // Appelle les function getters 
                $objet_normalise[$determineKey] = $res; // Construction de l'objet normalisé.
            }
        }
        return $objet_normalise;
    }

    public function encodeur($objet, $format = "json")
    {
        $objet_normalise = $this->normaliseur($objet);
        switch ($format) {
            case 'json':
                $objet_normalise_encode = json_encode($objet_normalise, JSON_FORCE_OBJECT);
                break;
            
            default:
                $objet_normalise_encode = json_encode($objet_normalise, JSON_FORCE_OBJECT);
                break;
        }
        return $objet_normalise_encode;
    }
}