<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérification : seul un admin peut accéder
checkAdmin();

$success = "";
$error = "";

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

    if (empty($title) || empty($deadline) || empty($id_employee) || empty($id_project)) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } else {
        $stmt = $pdo->prepare('INSERT INTO tasks (title, description, deadline, id_employee, id_project) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$title, $description, $deadline, $id_employee, $id_project]);

        $success = "Tâche ajoutée avec succès.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter une Tâche</h1>
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
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description de la Tâche</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
    </div>

    <div class="mb-3">
        <label>Projet Assigné</label>
        <select name="id_project" class="form-select" required>
            <option value="">-- Sélectionner un Projet --</option>
            <?php foreach ($projects as $project) : ?>
                <option value="<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['title']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Employé Assigné</label>
        <select name="id_employee" class="form-select" required>
            <option value="">-- Sélectionner un Employé --</option>
            <?php foreach ($employees as $employee) : ?>
                <option value="<?php echo $employee['id']; ?>"><?php echo htmlspecialchars($employee['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Deadline</label>
        <input type="date" name="deadline" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Ajouter la Tâche</button>
</form>

<?php include '../includes/footer.php'; ?>
