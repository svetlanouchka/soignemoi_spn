<?php

namespace App\Controller;

use App\Repository\SejourRepository;
use App\Repository\MedecinRepository;
use App\Repository\SpecialiteRepository;
use App\Repository\UserRepository;
use App\Repository\PlanningRepository;
use App\Entity\Sejour;
use App\Entity\User;
use App\Entity\Planning;
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
                    $this->checkAdmin();
                    $this->createSejour();
                    break;
                case 'list':
                    # appeler la méthode list()
                    $this->list();
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
    try {
        // Vérifier si l'utilisateur est connecté
        if (!User::isLogged()) {
            throw new \Exception("Utilisateur non connecté");
        }

        // Récupérer l'id de l'utilisateur connecté
        $user_id = User::getCurrentUserId();

        // Instancier les repositories
        $medecinRepository = new MedecinRepository();
        $specialiteRepository = new SpecialiteRepository();

        // Récupérer les données nécessaires
        $medecins = $medecinRepository->findAll(); 
        $specialites = $specialiteRepository->findAll(); 

        // Appel de la méthode create() avec toutes les données nécessaires
        $this->create($medecins, $specialites, $user_id);

    } catch (\Exception $e) {
        $this->render('errors/default', [
            'error' => $e->getMessage()
        ]);
    }
}

protected function create($medecins, $specialites, $user_id)
{
    try {
        $errors = [];
        $sejour = new Sejour();


        // Conversion des valeurs spécificiques en entiers avant l'hydratation
        $specialite_id = isset($_POST['specialite_id']) ? (int)$_POST['specialite_id'] : null;
        $medecin_id = isset($_POST['medecin_id']) ? (int)$_POST['medecin_id'] : null;

        // Hydratation de l'objet Sejour
        $sejour->setSpecialite_id($specialite_id);
        $sejour->setMedecin_id($medecin_id);
        $sejour->setUserId($user_id);

        if (isset($_POST['saveSejour'])) {
            
            $sejour->hydrate($_POST);

            $errors = $sejour->validate();
            var_dump($sejour);
            var_dump($errors);

            if (empty($errors)) {

                
                $sejourRepository = new SejourRepository();

                $planningRepository = new PlanningRepository();

                $planningDate = new \DateTime($_POST['date_debut']);
                $patientCount = $planningRepository->countPatientsByMedecinAndDate($sejour->getMedecin_Id(), $planningDate);

                if ($patientCount >= 5) {
                    $errors[] = "Le médecin a atteint le nombre maximum de patients pour cette journée.";
                }

                if (empty($errors)) {
                
                $sejourRepository->persist($sejour);

                $this->addSejourToPlanning($sejour, $planningDate);

                header('Location: index.php?controller=page&action=home');
                exit;
            } else {
                $errors[]="Erreur lors de l'insertion dans la base de données.";
            }
        }
    }

        $this->render('sejour/creation_sejour', [
            'pageTitle' => 'Création de sejour',
            'medecins' => $medecins,
            'specialites' => $specialites,
            'user_id' => $user_id,
            'errors' => $errors
        ]);

    } catch (\Exception $e) {
        $this->render('errors/default', [
            'error' => $e->getMessage()
        ]);
    } 

}

private function addSejourToPlanning(Sejour $sejour, \DateTime $date)
    {
        $planningRepository = new PlanningRepository();

        $planning = $planningRepository->findByMedecinIdAndDate($sejour->getMedecin_Id(), $date);

        if ($planning) {
            $planning->setNombrePatients($planning->getNombrePatients() + 1);
        } else {
            $planning = new Planning();
            $planning->setMedecinId($sejour->getMedecin_Id());
            $planning->setDate($date);
            $planning->setNombrePatients(1);
        }

        $planningRepository->save($planning);
    }
protected function show()
{
    try {
        if(isset($_GET['id'])) {
            
            $id = (int)$_GET['id'];
            // Charger le sejour par un appel au repository
            $sejourRepository = new SejourRepository();
            $sejour = $sejourRepository->findByUserId($id);

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
protected function list()
    {
        try {
            // Vérifier si l'utilisateur est connecté
            if (!User::isLogged()) {
                throw new \Exception("Utilisateur non connecté");
            }

            // Récupérer l'id de l'utilisateur connecté
            $user_id = User::getCurrentUserId();

            $sejourRepository = new SejourRepository();
            $sejours = $sejourRepository->findByUserId($user_id);

            $this->render('sejour/list', [
                'pageTitle' => 'Mes Séjours Médicaux',
                'sejours' => $sejours
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }
    private function checkAdmin(): void
    {
        if ($_SESSION['user_role'] !== 'admin') {
            throw new \Exception("Accès non autorisé");
        }
    }
}

