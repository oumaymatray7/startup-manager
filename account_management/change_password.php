<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// L'utilisateur doit être connecté
checkLogin();

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Le nouveau mot de passe et la confirmation ne correspondent pas.";
    } else {
        // Vérifier si l'ancien mot de passe est correct
        $stmt = $pdo->prepare('SELECT password FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($current_password, $user['password'])) {
            // Mettre à jour le mot de passe
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $stmt->execute([$new_hashed_password, $_SESSION['user_id']]);

            $success = "Mot de passe changé avec succès.";
        } else {
            $error = "Ancien mot de passe incorrect.";
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Changer mon mot de passe</h1>
    <a href="profile.php" class="btn btn-secondary">Retour au Profil</a>
</div>

<?php if (!empty($error)) : ?>
    <?php showError($error); ?>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <?php showSuccess($success); ?>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label>Mot de passe actuel</label>
        <input type="password" name="current_password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Nouveau mot de passe</label>
        <input type="password" name="new_password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Confirmer le nouveau mot de passe</label>
        <input type="password" name="confirm_password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Changer le mot de passe</button>
</form>

<?php include '../includes/footer.php'; ?>
