<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et Admin
checkAdmin();

// Charger les employés pour assigner les tâches
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'employee'");
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

$error = "";
$success = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitizeInput($_POST['title']);
    $description = sanitizeInput($_POST['description']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (empty($title) || empty($description) || empty($start_date) || empty($end_date)) {
        $error = "Tous les champs du projet sont obligatoires.";
    } else {
        // 1. Ajouter le projet
        $stmt = $pdo->prepare('INSERT INTO projects (title, description, start_date, end_date) VALUES (?, ?, ?, ?)');
        $stmt->execute([$title, $description, $start_date, $end_date]);

        // 2. Récupérer l'id du projet créé
        $project_id = $pdo->lastInsertId();

        // 3. Ajouter les tâches associées
        if (!empty($_POST['task_title'])) {
            foreach ($_POST['task_title'] as $index => $task_title) {
                $task_title = sanitizeInput($task_title);
                $assigned_to = intval($_POST['assigned_to'][$index]);
                $due_date = $_POST['due_date'][$index];

                if (!empty($task_title) && !empty($due_date)) {
                    $stmt = $pdo->prepare('INSERT INTO tasks (title, assigned_to, due_date, project_id) VALUES (?, ?, ?, ?)');
                    $stmt->execute([$task_title, $assigned_to, $due_date, $project_id]);
                }
            }
        }

        $success = "Projet et tâches ajoutés avec succès.";
        
        // Redirection après succès
        header('Location: list.php');
        exit();
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter un Projet</h1>
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
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Date de Début</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Date de Fin</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
    </div>

    <hr>

    <h5>Ajouter des Tâches</h5>

    <div id="tasks-container">
        <div class="task-item mb-3 border p-3 rounded bg-light">
            <div class="mb-2">
                <label class="form-label">Titre de la Tâche</label>
                <input type="text" name="task_title[]" class="form-control" placeholder="Titre de la tâche" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Assigner à</label>
                <select name="assigned_to[]" class="form-control" required>
                    <option value="">-- Sélectionner un employé --</option>
                    <?php foreach ($employees as $emp) : ?>
                        <option value="<?php echo $emp['id']; ?>"><?php echo htmlspecialchars($emp['username']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Date limite</label>
                <input type="date" name="due_date[]" class="form-control" required>
            </div>
        </div>
    </div>

    <div class="text-center mb-4">
        <button type="button" id="add-task" class="btn btn-outline-primary">+ Ajouter une autre tâche</button>
    </div>

    <button type="submit" class="btn btn-success w-100">Créer le projet et ses tâches</button>
</form>

<script>
// Ajouter dynamiquement des tâches
document.getElementById('add-task').addEventListener('click', function() {
    const container = document.getElementById('tasks-container');
    const taskItem = container.firstElementChild.cloneNode(true);

    // Réinitialiser les valeurs du clone
    taskItem.querySelectorAll('input, select').forEach(input => input.value = '');

    container.appendChild(taskItem);
});
</script>

<?php include '../includes/footer.php'; ?>
