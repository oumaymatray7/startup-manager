<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et Admin
checkAdmin();

// Charger les employés
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'employee'");
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Liste des Employés</h1>
    <div>
        <a href="../dashboard/dashboard_admin.php" class="btn btn-secondary btn-sm">← Retour Dashboard</a>
        <a href="add.php" class="btn btn-primary btn-sm">+ Ajouter Employé</a>
    </div>
</div>

<?php if (count($employees) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nom d'utilisateur</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $index => $employee) : ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($employee['username']); ?></td>
                        <td><?php echo htmlspecialchars($employee['email']); ?></td>
                        <td><?php echo htmlspecialchars($employee['phone']); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $employee['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="delete.php?id=<?php echo $employee['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet employé ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <div class="alert alert-info text-center">
        Aucun employé trouvé.
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
