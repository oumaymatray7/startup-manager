<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et est Admin
checkAdmin();

// Récupérer les statistiques principales
$nb_employes = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'employee'")->fetchColumn();
$nb_projets = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$nb_taches = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();

// Récupérer les messages envoyés
$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Bienvenue Administrateur 👨‍💼</h1>
    <a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a>
</div>

<div class="row">
    <!-- Carte Employés -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Employés</h5>
            </div>
            <div class="card-body text-center">
                <h3 class="card-title"><?php echo $nb_employes; ?> Employé(s)</h3>
                <a href="../employee_management/list.php" class="btn btn-outline-primary mt-3 w-100">Gérer les employés</a>
            </div>
        </div>
    </div>

    <!-- Carte Projets -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Projets</h5>
            </div>
            <div class="card-body text-center">
                <h3 class="card-title"><?php echo $nb_projets; ?> Projet(s)</h3>
                <a href="../project_management/list.php" class="btn btn-outline-success mt-3 w-100">Gérer les projets</a>
            </div>
        </div>
    </div>

    <!-- Carte Tâches -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Tâches</h5>
            </div>
            <div class="card-body text-center">
                <h3 class="card-title"><?php echo $nb_taches; ?> Tâche(s)</h3>
                <a href="../task_management/add_task.php" class="btn btn-outline-warning mt-3 w-100">Ajouter une tâche</a>
            </div>
        </div>
    </div>
</div>

<!-- Section Messages de Contact -->
<div class="card mt-5 shadow-sm">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">📩 Messages de Contact Reçus</h5>
    </div>
    <div class="card-body">
        <?php if (count($messages) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date d'envoi</th>
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
            </div>
        <?php else: ?>
            <p class="text-center">Aucun message reçu pour l'instant.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
