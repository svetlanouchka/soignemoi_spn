<?php require_once _ROOTPATH_ . '/templates/header.php'; ?>

<div class="container mt-5">
    <div class="alert alert-success" role="alert">
        <?= $flashMessage ?>
    </div>
    <a href="index.php?controller=page&action=home" class="btn btn-primary">Retour à l'accueil</a>
    <a href="index.php?controller=sejour&action=list" class="btn btn-secondary">Visualiser vos séjours</a>
</div>

<?php require_once _ROOTPATH_ . '/templates/footer.php'; ?>
