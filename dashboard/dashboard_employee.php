<?php 
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et est un employé
checkEmployee();

// Charger les projets liés aux tâches de l'employé
$stmt = $pdo->prepare('
    SELECT DISTINCT p.id, p.title
    FROM projects p
    INNER JOIN tasks t ON p.id = t.project_id
    WHERE t.assigned_to = ?
');
$stmt->execute([$_SESSION['user_id']]);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Charger toutes ses tâches
$stmt = $pdo->prepare('
    SELECT t.*, p.title AS project_title
    FROM tasks t
    LEFT JOIN projects p ON t.project_id = p.id
    WHERE t.assigned_to = ?
');
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Bienvenue 👨‍💻 <?php echo htmlspecialchars($_SESSION['username'] ?? 'Employé'); ?></h1>
    <a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a>
</div>

<div class="row">
    <!-- Carte Mes Projets -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Mes Projets</h5>
            </div>
            <div class="card-body">
                <?php if (count($projects) > 0): ?>
                    <ul class="list-group">
                        <?php foreach ($projects as $project): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($project['title']); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Vous n'êtes assigné à aucun projet pour le moment.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Carte Mes Tâches -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Mes Tâches</h5>
            </div>
            <div class="card-body">
                <?php if (count($tasks) > 0): ?>
                    <ul class="list-group">
                        <?php foreach ($tasks as $task): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?php echo htmlspecialchars($task['title']); ?></strong><br>
                                    <small class="text-muted">Projet : <?php echo htmlspecialchars($task['project_title']); ?></small><br>
                                    <small class="text-muted">Date limite : <?php echo htmlspecialchars($task['due_date']); ?></small>
                                </div>
                                <div>
                                    <?php if ($task['status'] != 'Terminée') : ?>
                                        <a href="../task_management/update_status.php?id=<?php echo $task['id']; ?>&status=Terminée" class="btn btn-sm btn-success">Terminer</a>
                                    <?php else : ?>
                                        <span class="badge bg-success">Complétée</span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Vous n'avez pas encore de tâches assignées.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
