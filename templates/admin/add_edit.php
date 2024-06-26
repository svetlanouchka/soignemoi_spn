<?php require_once _ROOTPATH_ . '\templates\header.php';
/** @var \App\Entity\Medecin $medecin */
?>
<div class="container mt-5">
    <h1 class="mb-4"><?= $pageTitle ?></h1>
    <form method="post">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="specialite">Spécialité</label>
            <input type="text" class="form-control" id="specialite" name="specialite" required>
        </div>
        <div class="form-group">
            <label for="matricule">Matricule</label>
            <input type="text" class="form-control" id="matricule" name="matricule" required>
        </div>
        <button type="submit" class="btn btn-primary" name="saveMedecin">Enregistrer</button>
    </form>
</div>


<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>