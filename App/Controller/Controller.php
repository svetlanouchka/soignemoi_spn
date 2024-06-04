<?php

namespace App\Controller;

Class Controller 
{
    public function route():void
    {
        if (isset($_GET['controller'])) {
            switch ($_GET['controller']) {
                case 'page':
                    # charger controleur page
                    var_dump('On charge PageControlleur');
                    break;

                case 'user':
                    # charger controleur User
                    var_dump('On charge UserControlleur');
                    break;
                default:
                    # Erreur
                    break;
            }
        } else {
            //Charger la page d'acceuil
        }    }
}