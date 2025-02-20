<?php require_once _ROOTPATH_ . '/templates/header.php';
/** @var \App\Entity\Sejour $sejour */
?>
<div class="container mt-5">
        <h1 class="mb-4"><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></h1>
        <div class="row">
            <div class="col-md-4">
                <h3>Séjours à venir</h3>
                <ul class="list-group">
                    <?php if (!empty($sejours)) : ?>
                        <?php foreach ($sejours as $sejour) : ?>
                            <?php if ($sejour->getDate_debut() > new DateTime()) : ?>
                                <li class="list-group-item">
                                    <strong>Date :</strong> <?= htmlspecialchars($sejour->getDate_debut()->format('Y-m-d'), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Motif :</strong> <?= htmlspecialchars($sejour->getMotif(), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Spécialité :</strong> <?= htmlspecialchars($sejour->getSpecialite()->getName(), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Médecin :</strong> <?= htmlspecialchars($sejour->getMedecin()->getNom() . ' ' . $sejour->getMedecin()->getPrenom(), ENT_QUOTES, 'UTF-8') ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item">Aucun séjour à venir.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Séjours en cours</h3>
                <ul class="list-group">
                    <?php if (!empty($sejours)) : ?>
                        <?php foreach ($sejours as $sejour) : ?>
                            <?php if ($sejour->getDate_debut() <= new DateTime() && $sejour->getDate_fin() >= new DateTime()) : ?>
                                <li class="list-group-item">
                                    <strong>Date :</strong> <?= htmlspecialchars($sejour->getDate_debut()->format('Y-m-d'), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Motif :</strong> <?= htmlspecialchars($sejour->getMotif(), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Spécialité :</strong> <?= htmlspecialchars($sejour->getSpecialite()->getName(), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Médecin :</strong> <?= htmlspecialchars($sejour->getMedecin()->getNom() . ' ' . $sejour->getMedecin()->getPrenom(), ENT_QUOTES, 'UTF-8') ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item">Aucun séjour en cours.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>Séjours effectués</h3>
                <ul class="list-group">
                    <?php if (!empty($sejours)) : ?>
                        <?php foreach ($sejours as $sejour) : ?>
                            <?php if ($sejour->getDate_fin() < new DateTime()) : ?>
                                <li class="list-group-item">
                                    <strong>Date :</strong> <?= htmlspecialchars($sejour->getDate_debut()->format('Y-m-d'), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Motif :</strong> <?= htmlspecialchars($sejour->getMotif(), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Spécialité :</strong> <?= htmlspecialchars($sejour->getSpecialite()->getName(), ENT_QUOTES, 'UTF-8') ?><br>
                                    <strong>Médecin :</strong> <?= htmlspecialchars($sejour->getMedecin()->getNom() . ' ' . $sejour->getMedecin()->getPrenom(), ENT_QUOTES, 'UTF-8') ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item">Aucun séjour effectué.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

<?php require_once _ROOTPATH_ . '/templates/footer.php' ?>