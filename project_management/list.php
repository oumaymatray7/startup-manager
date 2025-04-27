<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et Admin
checkAdmin();

// Charger tous les projets
$stmt = $pdo->prepare('SELECT * FROM projects ORDER BY start_date DESC');
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Liste des Projets</h1>
    <div>
        <a href="../dashboard/dashboard_admin.php" class="btn btn-secondary btn-sm">← Retour Dashboard</a>
        <a href="add.php" class="btn btn-primary btn-sm">+ Ajouter un projet</a>
    </div>
</div>

<?php if (count($projects) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Titre du Projet</th>
                    <th>Description</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $index => $project) : ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($project['title']); ?></td>
                        <td><?php echo htmlspecialchars(substr($project['description'], 0, 50)) . '...'; ?></td>
                        <td><?php echo htmlspecialchars($project['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($project['end_date']); ?></td>
                        <td>
                            <a href="view.php?id=<?php echo $project['id']; ?>" class="btn btn-sm btn-info">Voir</a>
                            <a href="edit.php?id=<?php echo $project['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="delete.php?id=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce projet ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <div class="alert alert-info text-center">
        Aucun projet trouvé.
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
