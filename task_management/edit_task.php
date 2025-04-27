<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérification : seul un admin peut accéder
checkAdmin();

// Vérifier que l'ID de la tâche est passé
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirectWithMessage('../project_management/list.php', 'error', 'ID de tâche invalide');
}

$id = intval($_GET['id']);
$error = "";
$success = "";

// Charger la tâche existante
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
$stmt->execute([$id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    redirectWithMessage('../project_management/list.php', 'error', 'Tâche introuvable');
}

// Charger la liste des projets
$stmt = $pdo->query('SELECT id, title FROM projects ORDER BY title');
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Charger la liste des employés
$stmt = $pdo->query('SELECT id, name FROM employees ORDER BY name');
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $deadline = $_POST['deadline'];
    $id_employee = $_POST['id_employee'];
    $id_project = $_POST['id_project'];
    $status = $_POST['status'];

    if (empty($title) || empty($deadline) || empty($id_employee) || empty($id_project) || empty($status)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        $stmt = $pdo->prepare('UPDATE tasks SET title = ?, description = ?, deadline = ?, id_employee = ?, id_project = ?, status = ? WHERE id = ?');
        $stmt->execute([$title, $description, $deadline, $id_employee, $id_project, $status, $id]);

        $success = "Tâche mise à jour avec succès.";

        // Recharger la tâche mise à jour
        $stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
        $stmt->execute([$id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier Tâche</h1>
    <a href="../project_management/list.php" class="btn btn-secondary">Retour aux Projets</a>
</div>

<?php if (!empty($error)) : ?>
    <?php showError($error); ?>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <?php showSuccess($success); ?>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label>Titre de la Tâche</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
    </div>

    <div class="mb-3">
        <label>Description de la Tâche</label>
        <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
    </div>

    <div class="mb-3">
        <label>Projet Assigné</label>
        <select name="id_project" class="form-select" required>
            <?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['id']; ?>" <?php if ($project['id'] == $task['id_project']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($project['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Employé Assigné</label>
        <select name="id_employee" class="form-select" required>
            <?php foreach ($employees as $employee) : ?>
                <option value="<?php echo $employee['id']; ?>" <?php if ($employee['id'] == $task['id_employee']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($employee['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Deadline</label>
        <input type="date" name="deadline" class="form-control" value="<?php echo htmlspecialchars($task['deadline']); ?>" required>
    </div>

    <div class="mb-3">
        <label>Statut</label>
        <select name="status" class="form-select" required>
            <option value="En cours" <?php if ($task['status'] == 'En cours') echo 'selected'; ?>>En cours</option>
            <option value="Terminé" <?php if ($task['status'] == 'Terminé') echo 'selected'; ?>>Terminé</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">Mettre à jour la Tâche</button>
</form>

<?php include '../includes/footer.php'; ?>
