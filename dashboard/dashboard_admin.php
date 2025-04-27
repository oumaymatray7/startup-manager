<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et est Admin
checkAdmin();

// Récupérer les données (compter employés, projets, tâches)
$nb_employes = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'employee'")->fetchColumn();
$nb_projets = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$nb_taches = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
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
            <div class="card-body">
                <h3 class="card-title text-center"><?php echo $nb_employes; ?> Employé(s)</h3>
                <a href="../employee_management/list.php" class="btn btn-outline-primary w-100 mt-3">Gérer les employés</a>
            </div>
        </div>
    </div>

    <!-- Carte Projets -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Projets</h5>
            </div>
            <div class="card-body">
                <h3 class="card-title text-center"><?php echo $nb_projets; ?> Projet(s)</h3>
                <a href="../project_management/list.php" class="btn btn-outline-success w-100 mt-3">Gérer les projets</a>
            </div>
        </div>
    </div>

    <!-- Carte Tâches -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Tâches</h5>
            </div>
            <div class="card-body">
                <h3 class="card-title text-center"><?php echo $nb_taches; ?> Tâche(s)</h3>
                <a href="../task_management/add_task.php" class="btn btn-outline-warning w-100 mt-3">Ajouter une tâche</a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
