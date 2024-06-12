<?php

namespace App\Controller;

use App\Repository\SejourRepository;

class SejourController extends Controller
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
            // Charger le sejour par un appel au repository
            $sejourRepository = new SejourRepository();
            $sejour = $sejourRepository->findOneById($id);

            $this->render('sejour/show', [
                'sejour' => $sejour,
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