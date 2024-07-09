<?php

namespace App\Controller;

use App\Repository\PrescriptionRepository;
use App\Entity\Prescription;

class PrescriptionController extends Controller
{
    public function route(): void
    {
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'createPrescription':
                        $this->createPrescription();
                        break;
                    case 'editPrescription':
                        $this->editPrescription();
                        break;
                    case 'deletePrescription':
                        $this->deletePrescription();
                        break;
                    case 'viewPrescriptions':
                        $this->viewPrescriptions();
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

    protected function createPrescription(): void
    {
        try {
            $errors = [];
            $prescription = new Prescription();
            
            if (isset($_POST['savePrescription'])) {
                $prescription->setLibelle($_POST['libelle']);
                $prescription->setDateprescription($_POST['date_prescription']);
                $prescription->setDescription($_POST['description']);
                $prescription->setMedecin_id($_POST['medecin_id']);
                $prescription->setSejour_id($_POST['sejour_id']);
                
                $errors = $prescription->validate();
                if (empty($errors)) {
                    $prescriptionRepository = new PrescriptionRepository();
                    $prescriptionRepository->create($prescription);
                    exit;
                }
            }

            $this->render('prescription/create', [
                'prescription' => $prescription,
                'success' => 'Prescription créée avec succès',
                'pageTitle' => 'Créer une prescription',
                'errors' => $errors,
                
            ]);
                
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function editPrescription(): void
    {
        try {
            $errors = [];
            $prescriptionRepository = new PrescriptionRepository();
            $prescription = $prescriptionRepository->findOneById($_GET['id']);
            
            if (isset($_POST['savePrescription'])) {
                $prescription->setLibelle($_POST['libelle']);
                $prescription->setDateprescription($_POST['date_prescription']);
                $prescription->setDescription($_POST['description']);
                $prescription->setMedecin_id($_POST['medecin_id']);
                $prescription->setSejour_id($_POST['sejour_id']);
                
                $errors = $prescription->validate();
                if (empty($errors)) {
                    $prescriptionRepository->update($prescription);
                    exit;
                }
            }

            $this->render('prescription/edit', [
                'prescription' => $prescription,
                'success' => 'Prescription modifiée avec succès',
                'pageTitle' => 'Modifier une prescription',
                'errors' => $errors,
                
            ]);
                
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function deletePrescription(): void
    {
        try {
            if (isset($_GET['id'])) {
                throw new \Exception("Identifiant de la prescription manquant");
            }
            $prescriptionRepository = new PrescriptionRepository();
            $prescription = $prescriptionRepository->findOneById($_GET['id']);
            if (!$prescription) {
                throw new \Exception("Prescription introuvable");
            }
            $prescriptionRepository->delete($prescription->getId());
            header('Location: index.php?controller=prescription&action=viewPrescriptions');
            exit;
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }

    protected function viewPrescriptions(): void
    {
        try {
            $prescriptionRepository = new PrescriptionRepository();
            $prescriptions = $prescriptionRepository->findAll();
            $this->render('prescription/index', [
                'prescriptions' => $prescriptions,
                'pageTitle' => 'Liste des prescriptions',
                
            ]);
        } catch (\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    }
}