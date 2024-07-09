<?php

namespace App\Controller;

use App\Repository\MedicamentRepository;
use App\Entity\Medicament;

class MedicamentController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'createMedicament':
                        $this->createMedicament();
                        break;
                    
                    case 'viewMedicaments':
                        $this->viewMedicaments();
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : " . $_GET['action']);
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function createMedicament()
    {
        try {
            $errors = [];
            $medicament = new Medicament();

            if (isset($_POST['saveMedicament'])) {
                $medicament->setNom($_POST['nom']);
                $medicament->setDescription($_POST['description']);

                $errors = $medicament->validate();
                if (empty($errors)) {
                    $medicamentRepository = new MedicamentRepository();
                    $medicamentRepository->create($medicament);
                    exit;
                }   
            }

            $this->render('medicament/create', [
                'medicament' => $medicament,
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }

    }

    protected function viewMedicaments()
    {
        try {
            if(isset($_GET['id'])) {
                $id = $_GET['id']; 
                $medicamentRepository = new MedicamentRepository();
                $medicament = $medicamentRepository->findOneById($id);
                $this->render('medicament/view', [
                    'medicament' => $medicament
                ]);
            } else {
                throw new \Exception("Aucun identifiant de médicament détecté");
        }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
}
}
