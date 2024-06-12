<?php

namespace App\Controller;

use App\Repository\MedecinRepository;

class MedecinController extends Controller

{
    public function route():void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'show':
                        # appeler la méthode about()
                        $this->show();
                        break;
                    case 'create':
                        # appeler la méthode about()
                        break;
                    case 'list':
                        # charger controleur home
                        break;
                    case 'add_planning':
                            # appeler la méthode about()
                            break;
                    default:
                        throw new \Exception("Cette action n'existe pas : ".$_GET['action']);
                        break;
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

            $medecinRepository = new MedecinRepository();
            $medecin = $medecinRepository->findOneById($id);
            var_dump($medecin);
            
            $this->render('medecin/show', [
                'medecin' => $medecin,
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

