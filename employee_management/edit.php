<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et Admin
checkAdmin();

// Vérifier si l'ID est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: list.php?error=ID invalide');
    exit();
}

$id = intval($_GET['id']);
$error = "";
$success = "";

// Récupérer les données actuelles de l'employé (dans `users`, pas `employees`)
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? AND role = "employee"');
$stmt->execute([$id]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

// Si l'employé n'existe pas
if (!$employee) {
    header('Location: list.php?error=Employé non trouvé');
    exit();
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);

    if (empty($email) || empty($phone)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Vérifier si email appartient déjà à un autre employé
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé par un autre utilisateur.";
        } else {
            // Mise à jour de l'employé
            $stmt = $pdo->prepare('UPDATE users SET email = ?, phone = ? WHERE id = ?');
            $stmt->execute([$email, $phone, $id]);

            $success = "Employé modifié avec succès.";
            // Recharger les nouvelles données
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$id]);
            $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}
?>

<!-- Formulaire HTML -->
<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier Employé</h1>
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
        <label class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($employee['username']); ?>" disabled>
        <small class="text-muted">Le nom d'utilisateur ne peut pas être modifié.</small>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Téléphone</label>
        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Enregistrer les modifications</button>
</form>

<?php include '../includes/footer.php'; ?>
