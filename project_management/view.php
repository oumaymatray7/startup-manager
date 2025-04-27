<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté
checkLogin();

// Vérifier que l'ID du projet est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list.php?error=ID invalide');
    exit();
}

$project_id = intval($_GET['id']);

// Charger les informations du projet
$stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ?');
$stmt->execute([$project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    header('Location: list.php?error=Projet introuvable');
    exit();
}

// Charger les tâches liées au projet
$stmt = $pdo->prepare('
    SELECT t.*, u.username AS employee_name 
    FROM tasks t 
    LEFT JOIN users u ON t.assigned_to = u.id 
    WHERE t.project_id = ?
');
$stmt->execute([$project_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Détails du Projet</h1>
    <a href="list.php" class="btn btn-secondary btn-sm">← Retour à la liste</a>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><?php echo htmlspecialchars($project['title']); ?></h5>
    </div>
    <div class="card-body">
        <p><strong>Description :</strong><br><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
        <p><strong>Date de début :</strong> <?php echo htmlspecialchars($project['start_date']); ?></p>
        <p><strong>Date de fin :</strong> <?php echo htmlspecialchars($project['end_date']); ?></p>
    </div>
</div>

<h4 class="mb-3">Tâches du Projet</h4>

<?php if (count($tasks) > 0) : ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Titre de la Tâche</th>
                    <th>Assigné à</th>
                    <th>Date Limite</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $index => $task) : ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo htmlspecialchars($task['title']); ?></td>
                        <td><?php echo htmlspecialchars($task['employee_name'] ?? 'Non assigné'); ?></td>
                        <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                        <td>
                            <?php echo $task['status'] ?? 'En attente'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <div class="alert alert-info text-center">
        Aucune tâche associée à ce projet.
    </div>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
