<?php require_once _ROOTPATH_ . '\templates\header.php';
/** @var \App\Entity\Medecin $medecin */
?>
<div class="container mt-5">
    <h1 class="mb-4"><?= $pageTitle ?></h1>
    <div class="list-group">
        <a href="index.php?controller=admin&action=createMedecin" class="list-group-item list-group-item-action">Créer un Médecin</a>
        <a href="index.php?controller=admin&action=viewMedecins" class="list-group-item list-group-item-action">Voir les Médecins</a>
        <a href="index.php?controller=admin&action=addPlanning" class="list-group-item list-group-item-action">Assigner un Planning</a>
        <a href="index.php?controller=admin&action=stats" class="list-group-item list-group-item-action">Voir les Statistiques</a>
    </div>
</div>

<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>