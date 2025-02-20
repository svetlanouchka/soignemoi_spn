<?php require_once _ROOTPATH_ . '/templates/header.php';
/** @var \App\Entity\Sejour $sejour */
?>

<div class="container mt-5">
    <h1><?= $pageTitle; ?></h1>
    <p class="lead">Planifiez et enregistrez vos séjours médicaux en sélectionnant votre médecin et spécialité, ainsi que les dates et motifs de votre consultation.</p>
    <form method="POST">
        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de début</label>
            <input type="date" class="form-control <?=(isset($errors['date_debut']) ? 'is-invalid': '') ?>" id="date_debut" name="date_debut" value="">
            <?php if(isset($errors['date_debut'])) { ?>
                <div class="invalid-feedback"><?=$errors['date_debut'] ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de fin</label>
            <input type="date" class="form-control <?=(isset($errors['date_fin']) ? 'is-invalid': '') ?>" id="date_fin" name="date_fin" value="">
            <?php if(isset($errors['date_fin'])) { ?>
                <div class="invalid-feedback"><?=$errors['date_fin'] ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="motif" class="form-label">Motif</label>
            <input type="text" class="form-control <?=(isset($errors['motif']) ? 'is-invalid': '') ?>" id="motif" name="motif" value="">
            <?php if(isset($errors['motif'])) { ?>
                <div class="invalid-feedback"><?=$errors['motif'] ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="specialite_id" class="form-label">Spécialité</label>
            <select name="specialite_id" id="specialite_id" class="form-control <?= (isset($errors['specialite_id']) ? 'is-invalid' : '') ?>">
                <option value="">Choisir une spécialité</option>
                <?php foreach ($specialites as $specialite) { ?>
                    <option value="<?= $specialite->getId() ?>"><?= $specialite->getName() ?> </option>
                <?php } ?>
            </select>
            <?php if (isset($errors['specialite_id'])) { ?>
                <div class="invalid-feedback"><?= $errors['specialite_id'] ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="medecin_id" class="form-label">Médecin</label>
            <select name="medecin_id" id="medecin_id" class="form-control <?= (isset($errors['medecin_id']) ? 'is-invalid' : '') ?>">
                <option value="">Choisir un médecin</option>
                <?php foreach ($medecins as $medecin) { ?>
                    <option value="<?= $medecin->getId() ?>"><?= $medecin->getNom() ?> <?= $medecin->getPrenom() ?></option>
                <?php } ?>
            </select>
            <?php if (isset($errors['medecin_id'])) { ?>
                <div class="invalid-feedback"><?= $errors['medecin_id'] ?></div>
            <?php } ?>
        </div>

        <input type="submit" name="saveSejour" class="btn btn-primary" value="Enregistrer">
    </form>
</div>

<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>
