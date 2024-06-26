<?php require_once _ROOTPATH_ . '\templates\header.php';
/** @var \App\Entity\Medecin $medecin */
?>

<div class="container mt-5">
    <h1 class="mb-4">Gestion de l'emploi du temps</h1>
    <form method="post" action="index.php?controller=medecin&action=planning">
        <input type="hidden" name="medecin_id" value="<?= $medecin_id ?>">
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="nombre_patients">Nombre de patients :</label>
            <input type="number" class="form-control" id="nombre_patients" name="nombre_patients" max="5" required>
        </div>
        <button type="submit" name="savePlanning" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>