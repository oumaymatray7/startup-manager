<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et Admin
checkAdmin();

$error = "";
$success = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($phone) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Vérifier que le username est unique
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "Ce nom d'utilisateur existe déjà.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare('INSERT INTO users (username, email, phone, password, role) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$username, $email, $phone, $hashed_password, 'employee']);

            $success = "Employé ajouté avec succès !";

            // Redirection après ajout
            header('Location: list.php');
            exit();
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ajouter un Employé</h1>
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
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Entrer un nom d'utilisateur" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Entrer l'email" required>
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Téléphone</label>
        <input type="text" name="phone" id="phone" class="form-control" placeholder="Entrer le numéro de téléphone" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Entrer un mot de passe" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Ajouter l'employé</button>
</form>

<?php include '../includes/footer.php'; ?>
