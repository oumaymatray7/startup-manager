<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';
checkAdmin();

// Données du tableau de bord
$nb_employes = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'employee'")->fetchColumn();
$nb_projets = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$nb_taches = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<!-- Titre de bienvenue -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold"> Bienvenue, Administrateur</h1>
    <a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a>
</div>

<div class="row g-4 mb-5">
    <!-- Box Employés -->
    <div class="col-md-4">
        <div class="dashboard-box employee">
            <h5>👥 Employés</h5>
            <h2><?php echo $nb_employes; ?></h2>
            <a href="../employee_management/list.php" class="btn btn-outline-primary mt-auto">Gérer les employés</a>
        </div>
    </div>

    <!-- Box Projets -->
    <div class="col-md-4">
        <div class="dashboard-box project">
            <h5> Projets</h5>
            <h2><?php echo $nb_projets; ?></h2>
            <a href="../project_management/list.php" class="btn btn-outline-success mt-auto">Gérer les projets</a>
        </div>
    </div>

    <!-- Box Tâches -->
    <div class="col-md-4">
        <div class="dashboard-box task">
            <h5>Tâches</h5>
            <h2><?php echo $nb_taches; ?></h2>
            <a href="../task_management/add_task.php" class="btn btn-outline-warning mt-auto">Ajouter une tâche</a>
        </div>
    </div>
</div>

<!-- Section Messages de Contact -->
<div class="contact-messages-box">
    <div class="header">
        <i class="bi bi-envelope-paper-fill fs-5"></i>
        📩 Messages de Contact Reçus
    </div>
    <div class="table-container">
        <?php if (count($messages) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($msg['name']); ?></td>
                            <td><?php echo htmlspecialchars($msg['email']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($msg['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted text-center m-0">Aucun message reçu pour l'instant.</p>
        <?php endif; ?>
    </div>
</div>


<?php include '../includes/footer.php'; ?>
