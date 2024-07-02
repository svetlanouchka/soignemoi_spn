<?php

namespace App\Controller;

use App\Repository\MedecinRepository;
use App\Entity\Medecin;
use App\Repository\PlanningRepository;
use App\Repository\SpecialiteRepository;
use App\Repository\SejourRepository;
use App\Entity\Planning;
class AdminController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'createMedecin':
                        $this->checkAdmin();
                        $this->createMedecin();
                        break;
                    case 'editMedecin':
                        $this->checkAdmin();
                        $this->editMedecin();
                        break;
                    case 'deleteMedecin':
                        $this->checkAdmin();
                        $this->deleteMedecin();
                        break;
                    case 'viewMedecins':
                        $this->checkAdmin();
                        $this->viewMedecins();
                        break;
                    case 'addPlanning':
                        $this->checkAdmin();
                        $this->addPlanning();
                        break;
                    case 'viewPlanningByMedecinId':
                        $this->checkAdmin();
                        $this->viewPlanningByMedecinId((int)$_GET['medecin_id']);
                    case 'dashboard':
                        $this->checkAdmin();
                        $this->dashboard();
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : " . $_GET['action']);
                }
            } else {
                $this->checkAdmin();
                $this->dashboard();
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function dashboard(): void
    {
        $this->render('admin/dashboard', [
            'pageTitle' => 'Espace Admin'
        ]);
    }


    protected function createMedecin(): void
    {
        try {
            $errors = [];
            $medecin = new Medecin();

            $specialiteRepository = new SpecialiteRepository();
            $specialites = $specialiteRepository->findAll();

            if (isset($_POST['saveMedecin'])) {
                $medecin->setNom($_POST['nom']);
                $medecin->setPrenom($_POST['prenom']);
                $medecin->setSpecialite_id($_POST['specialite_id']);
                $medecin->setMatricule($_POST['matricule']);

                $errors = $medecin->validate();

                if (empty($errors)) {
                    $medecinRepository = new MedecinRepository();
                    $medecinRepository->save($medecin);
                    header('Location: index.php?controller=admin&action=viewMedecins');
                    exit;
                }
            }

            $this->render('admin/add_edit', [
                'medecin' => $medecin,
                'specialites' => $specialites,
                'pageTitle' => 'Créer un médecin',
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function viewMedecins(): void
    {
        try {
            $medecinRepository = new MedecinRepository();
            $medecins = $medecinRepository->findAllWithSpecialites();
            
            $this->render('admin/list', [
                'medecins' => $medecins,
                'pageTitle' => 'Liste des médecins'
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }
    protected function addPlanning(): void
    {
        try {
            if (isset($_POST['savePlanning'])) {
                $medecin_id = $_POST['medecin_id'];
                $date_i = new \DateTime($_POST['date_i']);
                $planningRepository = new PlanningRepository();

                $planning = $planningRepository->findByMedecinIdAndDate($medecin_id, $date_i);

                if ($planning === null) {
                    $planning = new Planning();
                    $planning->setMedecinId($medecin_id);
                    $planning->setDate_i($date_i);
                }

                $planning->setNombrePatients($_POST['nombre_patients']);
                $planningRepository->save($planning, $date_i);

                header('Location: index.php?controller=medecin&action=planning&medecin_id=' . $medecin_id);
                exit;
            } else {
                $medecin_id = $_GET['medecin_id'];
                $this->render('admin/planning', [
                    'medecin_id' => $medecin_id
                ]);
            }
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function checkAdmin(): void
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            throw new \Exception("Accès interdit. Vous devez être administrateur pour effectuer cette action.");
        }
    }

    protected function editMedecin(): void
    {
        try {
            $medecinRepository = new MedecinRepository();
            $errors = [];

            if (isset($_POST['saveMedecin'])) {
                $medecin = $medecinRepository->findOneById($_POST['id']);
                if ($medecin) {
                    $medecin->hydrate($_POST);
                    $errors = $medecin->validate();

                    if (empty($errors)) {
                        $medecinRepository->update($medecin);
                        header('Location: index.php?controller=medecin&action=list');
                        exit;
                    }
                } else {
                    throw new \Exception("Médecin non trouvé.");
                }
            } else {
                if (!isset($_GET['id'])) {
                    throw new \Exception("Aucun ID de médecin fourni.");
                }

                $medecin = $medecinRepository->findOneById($_GET['id']);
                if (!$medecin) {
                    throw new \Exception("Médecin non trouvé.");
                }
            }

            $this->render('admin/edit', [
                'medecin' => $medecin,
                'pageTitle' => 'Modifier Médecin',
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function deleteMedecin(): void
    {
        try {
            if (!isset($_GET['id'])) {
                throw new \Exception("Aucun ID de médecin fourni.");
            }

            $medecinRepository = new MedecinRepository();
            $medecin = $medecinRepository->findOneById($_GET['id']);
            if (!$medecin) {
                throw new \Exception("Médecin non trouvé.");
            }

            $medecinRepository->delete($medecin->getId());
            header('Location: index.php?controller=medecin&action=list');
            exit;
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
}

protected function viewPlanningByMedecinId(int $medecin_id): void
{
    try {
        // Récupérer le médecin à partir de l'ID
        $medecinRepository = new MedecinRepository();
        $medecin = $medecinRepository->findOneById($medecin_id);

        if (!$medecin) {
            throw new \Exception("Médecin non trouvé avec l'ID : " . $medecin_id);
        }

        // Récupérer les plannings associés à ce médecin
        $planningRepository = new PlanningRepository();
        $plannings = $planningRepository->findByMedecinId($medecin_id);

        // Rendre la vue avec les données récupérées
        $this->render('admin/view_planning', [
            'plannings' => $plannings,
            'medecin' => $medecin,
            'pageTitle' => 'Planning du médecin ' . $medecin->getNomComplet()
        ]);
    } catch (\Exception $e) {
        $this->render('errors/default', [
            'error' => $e->getMessage()
        ]);
    }
}
}

