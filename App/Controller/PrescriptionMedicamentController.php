<?php

namespace App\Controller;

use App\Entity\PrescriptionMedicament;
use App\Repository\PrescriptionMedicamentRepository;

class PrescriptionMedicamentController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'createPrescriptionMedicament':
                        $this->createPrescriptionMedicament();
                        break;
                    case 'editPrescriptionMedicament':
                        $this->editPrescriptionMedicament();
                        break;
                    case 'deletePrescriptionMedicament':
                        $this->deletePrescriptionMedicament();
                        break;
                    case 'viewPrescriptionMedicaments':
                        $this->viewPrescriptionMedicaments();
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

    protected function createPrescriptionMedicament(): void
    {
        try {
            $errors = [];
            $prescriptionMedicament = new PrescriptionMedicament();

            if (isset($_POST['savePrescriptionMedicament'])) {
                $prescriptionMedicament->setPrescription_id($_POST['prescription_id']);
                $prescriptionMedicament->setMedicament_id($_POST['medicament_id']);
                $prescriptionMedicament->setPosologie($_POST['posologie']);
                $prescriptionMedicament->setDatedebut($_POST['datedebut']);
                $prescriptionMedicament->setDatefin($_POST['datefin']);

                $errors = $prescriptionMedicament->validate();
                if (empty($errors)) {
                    $prescriptionMedicamentRepository = new PrescriptionMedicamentRepository();
                    $prescriptionMedicamentRepository->create($prescriptionMedicament);
                    exit;
                }
            }

            $this->render('prescription_medicament/create', [
                'prescriptionMedicament' => $prescriptionMedicament,
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function editPrescriptionMedicament(): void
    {
        try {
            $errors = [];
            $prescriptionMedicamentRepository = new PrescriptionMedicamentRepository();
            $prescriptionMedicament = $prescriptionMedicamentRepository->findOneById($_GET['id']);

            if (isset($_POST['savePrescriptionMedicament'])) {
                $prescriptionMedicament->setPrescription_id($_POST['prescription_id']);
                $prescriptionMedicament->setMedicament_id($_POST['medicament_id']);
                $prescriptionMedicament->setPosologie($_POST['posologie']);
                $prescriptionMedicament->setDatedebut($_POST['datedebut']);
                $prescriptionMedicament->setDatefin($_POST['datefin']);

                $errors = $prescriptionMedicament->validate();
                if (empty($errors)) {
                    $prescriptionMedicamentRepository->update($prescriptionMedicament);
                    exit;
                }
            }

            $this->render('prescription_medicament/edit', [
                'prescriptionMedicament' => $prescriptionMedicament,
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function deletePrescriptionMedicament(): void
    {
        try {
            if (isset($_GET['id'])) {
                throw new \Exception("Aucun identifiant de prescription_medicament spécifié");
            }
            $prescriptionMedicamentRepository = new PrescriptionMedicamentRepository();
            $prescriptionMedicament = $prescriptionMedicamentRepository->findOneById($_GET['id']);
            if (!$prescriptionMedicament) {
                throw new \Exception("PrescriptionMedicament non trouvé");
            }
            $prescriptionMedicamentRepository->delete($prescriptionMedicament);
            header('Location: index.php?controller=avis&action=viewPrescriptionMedicaments');
            exit;
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function viewPrescriptionMedicaments(): void
    {
        try {
            $prescriptionMedicamentRepository = new PrescriptionMedicamentRepository();
            $prescriptionMedicaments = $prescriptionMedicamentRepository->findAll();
            $this->render('prescription_medicament/index', [
                'prescriptionMedicaments' => $prescriptionMedicaments
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }
}