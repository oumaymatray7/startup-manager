<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et Admin
checkAdmin();

// Vérifier que l'ID du projet est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list.php?error=ID invalide');
    exit();
}

$project_id = intval($_GET['id']);
$error = "";
$success = "";

// Charger projet
$stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ?');
$stmt->execute([$project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    header('Location: list.php?error=Projet introuvable');
    exit();
}

// Charger les tâches associées
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE project_id = ?');
$stmt->execute([$project_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Charger les employés pour la liste déroulante
$stmt = $pdo->prepare('SELECT * FROM users WHERE role = "employee"');
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitizeInput($_POST['title']);
    $description = sanitizeInput($_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (empty($title) || empty($description) || empty($start_date) || empty($end_date)) {
        $error = "Tous les champs du projet sont obligatoires.";
    } else {
        // 1. Mise à jour du projet
        $stmt = $pdo->prepare('UPDATE projects SET title = ?, description = ?, start_date = ?, end_date = ? WHERE id = ?');
        $stmt->execute([$title, $description, $start_date, $end_date, $project_id]);

        // 2. Mise à jour des tâches
        if (!empty($_POST['task_id'])) {
            foreach ($_POST['task_id'] as $index => $task_id) {
                $task_title = sanitizeInput($_POST['task_title'][$index]);
                $assigned_to = intval($_POST['assigned_to'][$index]);
                $due_date = $_POST['due_date'][$index];

                if (!empty($task_title) && !empty($due_date)) {
                    $stmt = $pdo->prepare('UPDATE tasks SET title = ?, assigned_to = ?, due_date = ? WHERE id = ? AND project_id = ?');
                    $stmt->execute([$task_title, $assigned_to, $due_date, $task_id, $project_id]);
                }
            }
        }

        $success = "Projet et tâches modifiés avec succès.";
        
        // Recharger projet et tâches après modification
        header('Location: list.php');
        exit();
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier Projet</h1>
    <a href="list.php" class="btn btn-secondary btn-sm">← Retour à la liste</a>
</div>

<?php if (!empty($error)) : ?>
    <?php showError($error); ?>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <?php showSuccess($success); ?>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label class="form-label">Titre du Projet</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($project['title']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($project['description']); ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Date de Début</label>
            <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($project['start_date']); ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Date de Fin</label>
            <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($project['end_date']); ?>" required>
        </div>
    </div>

    <hr>

    <h5>Modifier les Tâches</h5>

    <?php foreach ($tasks as $task) : ?>
        <div class="task-item mb-3 border p-3 rounded bg-light">
            <input type="hidden" name="task_id[]" value="<?php echo $task['id']; ?>">

            <div class="mb-2">
                <label class="form-label">Titre de la Tâche</label>
                <input type="text" name="task_title[]" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Assigner à</label>
                <select name="assigned_to[]" class="form-control" required>
                    <option value="">-- Sélectionner un employé --</option>
                    <?php foreach ($employees as $emp) : ?>
                        <option value="<?php echo $emp['id']; ?>" <?php if ($emp['id'] == $task['assigned_to']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($emp['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-2">
                <label class="form-label">Date limite</label>
                <input type="date" name="due_date[]" class="form-control" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
            </div>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-success w-100 mt-4">Enregistrer les modifications</button>
</form>

<?php include '../includes/footer.php'; ?>
