<?php

namespace App\Controller;

use App\Repository\SpecialiteRepository;
use App\Entity\Specialite;
class SpecialiteController extends Controller

{
    public function route():void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'show':
                        # appeler la méthode show
                        $this->show();
                        break;
                    case 'create':
                        # appeler la méthode create
                        break;
                    case 'list':
                        # charger controleur home
                        break;
                    case 'add_planning':
                            # appeler la méthode about()
                            break;
                    default:
                        throw new \Exception("Cette action n'existe pas : ".$_GET['action']);
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }  
        } catch(\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

protected function show()
{
    try {
        if(isset($_GET['id'])) {
            
            $id = (int)$_GET['id'];
            // Charger le medecin par un appel au repository

            $specialiteRepository = new SpecialiteRepository();
            $specialite = $specialiteRepository->findOneById($id);
            
            $this->render('specialite/show', [
                'specialite' => $specialite,
            ]);
        } else {
            throw new \Exception("L'id est manquant en paramètre");
        }

    } catch (\Exception $e) {
        $this->render('errors/default', [
            'error' => $e->getMessage()
        ]);
    }

}


}

