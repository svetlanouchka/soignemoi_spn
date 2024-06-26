<?php require_once _ROOTPATH_ . '\templates\header.php';
/** @var \App\Entity\Medecin $medecin */
?>

<div class="container mt-5">
    <h1 class="mb-4">Liste des Médecins</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Spécialité</th>
                <th>Matricule</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medecins as $medecin): ?>
                <tr>
                    <td><?= htmlspecialchars($medecin->getId()) ?></td>
                    <td><?= htmlspecialchars($medecin->getNom()) ?></td>
                    <td><?= htmlspecialchars($medecin->getPrenom()) ?></td>
                    <td><?= htmlspecialchars($medecin->getSpecialite_id()) ?></td>
                    <td><?= htmlspecialchars($medecin->getMatricule()) ?></td>
                    <td>
                        <a href="index.php?controller=medecin&action=edit&id=<?= $medecin->getId() ?>" class="btn btn-warning">Modifier</a>
                        <a href="index.php?controller=medecin&action=delete&id=<?= $medecin->getId() ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce médecin ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once _ROOTPATH_.'\templates\footer.php'; ?>