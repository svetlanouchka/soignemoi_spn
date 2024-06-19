<?php

namespace App\Controller;

use App\Repository\SejourRepository;
use App\Repository\MedecinRepository;
use App\Repository\SpecialiteRepository;
use App\Entity\Sejour;
use App\Entity\Medecin;
use App\Entity\Specialite;

class SejourController extends Controller
{
    public function route():void
    {
    try {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'show':
                    # appeler la méthode show()
                    $this->show();
                    break;
                case 'create':
                    # appeler la méthode create()
                    $this->createSejour();
                    break;
                case 'list':
                    # appeler la méthode list()
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

public function createSejour()
{

    $medecinRepository = new MedecinRepository();
    $specialiteRepository = new SpecialiteRepository();

    $medecins = $medecinRepository->findAll(); 
    $specialites = $specialiteRepository->findAll(); 

    // Appel de la méthode create() avec les données nécessaires
    $this->create($medecins, $specialites);
}


protected function create($medecins, $specialites)
{
    try {
        $errors = [];
        $sejour = new Sejour();

        if (isset($_POST['saveSejour'])) {
            
            $sejour->hydrate($_POST);


            $errors = $sejour->validate();

            if (empty($errors)) {
                $sejourRepository = new SejourRepository();
                
                $sejourRepository->persist($sejour);
                header('Location: index.php?controller=page&action=home');
            }
        }

        $this->render('sejour/creation_sejour', [
            'pageTitle' => 'Création de sejour',
            'medecins' => $medecins,
            'specialites' => $specialites,
            'errors' => $errors
        ]);

    } catch (\Exception $e) {
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