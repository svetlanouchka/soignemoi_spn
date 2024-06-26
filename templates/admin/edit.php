<?php require_once _ROOTPATH_ . '\templates\header.php';
/** @var \App\Entity\Medecin $medecin */
?>

<div class="container mt-5">
    <h1 class="mb-4"><?= $pageTitle ?></h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=medecin&action=edit">
        <input type="hidden" name="id" value="<?= htmlspecialchars($medecin->getId()) ?>">

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($medecin->getNom()) ?>" required>
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($medecin->getPrenom()) ?>" required>
        </div>

        <div class="mb-3">
            <label for="specialite" class="form-label">Spécialité</label>
            <input type="text" class="form-control" id="specialite" name="specialite" value="<?= htmlspecialchars($medecin->getSpecialite_id()) ?>" required>
        </div>

        <div class="mb-3">
            <label for="matricule" class="form-label">Matricule</label>
            <input type="text" class="form-control" id="matricule" name="matricule" value="<?= htmlspecialchars($medecin->getMatricule()) ?>" required>
        </div>

        <button type="submit" class="btn btn-primary" name="saveMedecin">Enregistrer</button>
    </form>
</div>

<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>