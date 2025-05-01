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

// Charger la liste des employés (depuis users)
$stmt = $pdo->query("SELECT id, username FROM users WHERE role = 'employee' ORDER BY username");
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
        $stmt = $pdo->prepare('INSERT INTO tasks (title, description, deadline, assigned_to, project_id, status) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$title, $description, $deadline, $id_employee, $id_project, 'En cours']);
        
        

        // Ajouter automatiquement l'employé comme membre du projet (si pas déjà)
        $check = $pdo->prepare("SELECT COUNT(*) FROM project_members WHERE id_project = ? AND id_user = ?");
        $check->execute([$id_project, $id_employee]);
        if (!$check->fetchColumn()) {
            $insert = $pdo->prepare("INSERT INTO project_members (id_project, id_user) VALUES (?, ?)");
            $insert->execute([$id_project, $id_employee]);
        }

        $success = "Tâche ajoutée avec succès.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter une Tâche</h1>
    <a href="../project_management/list.php" class="btn btn-secondary">Retour aux Projets</a>
</div>

<?php if (!empty($error)) showError($error); ?>
<?php if (!empty($success)) showSuccess($success); ?>

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
                <option value="<?= $project['id'] ?>"><?= htmlspecialchars($project['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Employé Assigné</label>
        <select name="id_employee" class="form-select" required>
            <option value="">-- Sélectionner un Employé --</option>
            <?php foreach ($employees as $emp) : ?>
                <option value="<?= $emp['id'] ?>"><?= htmlspecialchars($emp['username']) ?></option>
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
