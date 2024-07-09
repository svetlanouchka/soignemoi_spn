<?php
namespace App\Controller;

use App\Repository\AvisRepository;
use Exception;
use App\Entity\Avis;

class AvisController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'createAvis':
                        $this->createAvis();
                        break;
                    case 'editAvis':
                        $this->editAvis();
                        break;
                    case 'deleteAvis':
                        $this->deleteAvis();
                        break;
                    case 'viewAvis':
                        $this->viewAvis();
                        break;
                    default:
                        throw new Exception("Cette action n'existe pas : " . $_GET['action']);
                }
            } else {
                throw new Exception("Aucune action détectée");
            }
        } catch (Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function createAvis(): void
    {
        try {
            $errors = [];
            $avis = new Avis();
            
            if (isset($_POST['saveAvis'])) {
                $avis->setLibelle($_POST['libelle']);
                $avis->setDateavis($_POST['date_avis']);
                $avis->setDescription($_POST['description']);
                $avis->setMedecin_id($_POST['medecin_id']);
                $avis->setSejour_id($_POST['sejour_id']);
                
                $errors = $avis->validate();
                if (empty($errors)) {
                    $avisRepository = new AvisRepository();
                    $avisRepository->create($avis);
                    exit;
                }
            }
                
                $this->render('avis/create', [
                    'avis' => $avis,
                    'success' => 'Avis créé avec succès',
                    'pageTitle' => 'Créer un avis',
                    'errors' => $errors
                ]);
            } catch (Exception $e) {
                $this->render('errors/default', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        protected function editAvis(): void
        {
            try {
                $errors = [];
                $avis = new Avis();
                
                if (isset($_POST['saveAvis'])) {
                    $avis->setId($_POST['id']);
                    $avis->setLibelle($_POST['libelle']);
                    $avis->setDateavis($_POST['date_avis']);
                    $avis->setDescription($_POST['description']);
                    $avis->setMedecin_id($_POST['medecin_id']);
                    $avis->setSejour_id($_POST['sejour_id']);
                    
                    $errors = $avis->validate();
                    if (empty($errors)) {
                        $avisRepository = new AvisRepository();
                        $avisRepository->create($avis);
                        exit;
                    }
                }
                    
                    $this->render('avis/edit', [
                        'avis' => $avis,
                        'success' => 'Avis modifié avec succès',
                        'pageTitle' => 'Modifier un avis',
                        'errors' => $errors
                    ]);
                } catch (Exception $e) {
                    $this->render('errors/default', [
                        'error' => $e->getMessage()
                    ]);
                }
            }

            protected function deleteAvis(): void
            {
                try {
                    if (isset($_GET['id'])) {
                        throw new Exception("L'id est manquant en paramètre");
                    }
                        $avisRepository = new AvisRepository();
                        $avis = $avisRepository->findOneById($_GET['id']); 
                        if (!$avis) {
                            throw new Exception("Avis introuvable");
                        }
                            $avisRepository->delete($avis->getId());
                            header('Location: index.php?controller=avis&action=viewAvis');
                        exit;
                } catch (Exception $e) {
                    $this->render('errors/default', [
                        'error' => $e->getMessage()
                    ]);
                }
            }

            protected function viewAvis(): void
            {
                try {
                    $avisRepository = new AvisRepository();
                    $avis = $avisRepository->findAll();
                    $this->render('avis/view', [
                        'avis' => $avis,
                        'pageTitle' => 'Liste des avis'
                    ]);
                } catch (Exception $e) {
                    $this->render('errors/default', [
                        'error' => $e->getMessage()
                    ]);
                }
            }
    }




                    