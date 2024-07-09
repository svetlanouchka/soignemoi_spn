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
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="text" class="form-control" id="password" name="password" required>
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
        <div class="form-group">
            <label for="matricule">Matricule</label>
            <input type="text" class="form-control" id="matricule" name="matricule" required>
        </div>
        <button type="submit" class="btn btn-primary" name="saveMedecin">Enregistrer</button>
    </form>
</div>


<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>