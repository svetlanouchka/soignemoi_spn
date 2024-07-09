<?php require_once _ROOTPATH_ . '\templates\header.php';
/** @var \App\Entity\User $user */
?>

<div class="container mt-5">
    <h1><?= $pageTitle; ?></h1>

    <form method="POST">
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control <?=(isset($errors['prenom']) ? 'is-invalid': '') ?>" id="prenom" name="prenom" value="">
            <?php if(isset($errors['prenom'])) { ?>
                <div class="invalid-feedback"><?=$errors['prenom'] ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control <?=(isset($errors['nom']) ? 'is-invalid': '') ?>" id="nom" name="nom" value="">
            <?php if(isset($errors['nom'])) { ?>
                <div class="invalid-feedback"><?=$errors['nom'] ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control <?=(isset($errors['email']) ? 'is-invalid': '') ?>" id="email" name="email" value="">
            <?php if(isset($errors['email'])) { ?>
                <div class="invalid-feedback"><?=$errors['email'] ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="adress" class="form-label">Adresse postale</label>
            <input type="text" class="form-control <?=(isset($errors['adress']) ? 'is-invalid': '') ?>" id="adress" name="adress" value="">
            <?php if(isset($errors['adress'])) { ?>
                <div class="invalid-feedback"><?=$errors['adress'] ?></div>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control <?=(isset($errors['password']) ? 'is-invalid': '') ?>" id="password" name="password" value="">
            <?php if(isset($errors['password'])) { ?>
                <div class="invalid-feedback"><?=$errors['password'] ?></div>
            <?php } ?>
        </div>

        <input type="submit" name="saveUser" class="btn btn-primary" value="Enregistrer">
    </form>
</div>

<?php require_once _ROOTPATH_ . '\templates\footer.php' ?>
