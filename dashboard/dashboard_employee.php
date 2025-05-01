<?php 
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

checkEmployee();

// Projets de l'employé
$stmt = $pdo->prepare('
    SELECT DISTINCT p.id, p.title
    FROM projects p
    INNER JOIN tasks t ON p.id = t.project_id
    WHERE t.assigned_to = ?
');
$stmt->execute([$_SESSION['user_id']]);
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tâches de l'employé
$stmt = $pdo->prepare('
    SELECT t.*, p.title AS project_title
    FROM tasks t
    LEFT JOIN projects p ON t.project_id = p.id
    WHERE t.assigned_to = ?
');
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tri par statut
$completed_tasks = array_filter($tasks, fn($t) => strtolower(trim($t['status'])) === 'terminée');

$ongoing_tasks   = array_filter($tasks, fn($t) => strtolower(trim($t['status'])) !== 'terminée');

include '../includes/header.php';


// Encouragements du jour
$encouragements = [
    "🚀 Garde le cap, tu es sur la bonne voie !",
    "🌟 Chaque tâche terminée est un pas vers l'excellence.",
    "🔥 Aujourd’hui est une nouvelle chance d’exceller.",
    "💡 La concentration est la clé de la réussite.",
    "🏆 Tes efforts d'aujourd’hui sont les succès de demain.",
];
$motivation = $encouragements[array_rand($encouragements)];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Bienvenue 👨‍💻 <?= htmlspecialchars($_SESSION['username'] ?? 'Employé'); ?></h1>
    <a href="../auth/logout.php" class="btn btn-danger">Déconnexion</a>
</div>

<!-- ✅ Encouragement du jour -->
<div class="alert alert-info shadow-sm text-center fs-6 fw-semibold">
    <?= $motivation ?>
</div>




<div class="row">
    <!-- Projets -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📁 Mes Projets</h5>
            </div>
            <div class="card-body">
                <?php if ($projects): ?>
                    <ul class="list-group">
                        <?php foreach ($projects as $project): ?>
                            <li class="list-group-item"><?= htmlspecialchars($project['title']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Aucun projet assigné.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tâches en cours -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">🕓 Tâches en cours</h5>
            </div>
            <div class="card-body">
                <?php if ($ongoing_tasks): ?>
                    <ul class="list-group">
                        <?php foreach ($ongoing_tasks as $task): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center rounded mb-2">
                                <div>
                                    <strong><?= htmlspecialchars($task['title']) ?></strong><br>
                                    <small class="text-muted">Projet : <?= htmlspecialchars($task['project_title']) ?></small><br>
                                    <small class="text-muted">📅 Deadline : <?= htmlspecialchars($task['due_date']) ?></small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-warning text-dark mb-1">⏳ En cours</span><br>
                                    <a href="../task_management/update_status.php?id=<?= $task['id']; ?>&status=Terminée"
                                       class="btn btn-sm btn-outline-success mt-1"
                                       data-bs-toggle="tooltip" title="Marquer comme terminée">
                                        ✅ Terminer
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Aucune tâche en cours.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tâches terminées -->
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">✅ Tâches Terminées</h5>
            </div>
            <div class="card-body">
                <?php if ($completed_tasks): ?>
                    <ul class="list-group">
                        <?php foreach ($completed_tasks as $task): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center bg-danger bg-opacity-10 border-danger mb-2">
                                <div>
                                    <strong><?= htmlspecialchars($task['title']) ?></strong><br>
                                    <small class="text-muted">Projet : <?= htmlspecialchars($task['project_title']) ?></small><br>
                                    <small class="text-muted">📅 Deadline : <?= htmlspecialchars($task['due_date']) ?></small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger text-white"
                                          data-bs-toggle="tooltip"
                                          title="Tâche terminée">
                                          ✔️ Terminée
                                    </span><br>
                                    <a href="../task_management/update_status.php?id=<?= $task['id']; ?>&status=En%20cours"
                                       class="btn btn-sm btn-outline-warning mt-1"
                                       data-bs-toggle="tooltip"
                                       title="Reprendre la tâche">
                                        ↩️ Reprendre
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Aucune tâche terminée.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Tooltips Bootstrap
document.addEventListener('DOMContentLoaded', function () {
    const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltips.forEach(t => new bootstrap.Tooltip(t))
});
</script>

<?php include '../includes/footer.php'; ?>
