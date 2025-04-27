<?php
include '../includes/db.php';
session_start();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header('Location: ../dashboard/dashboard_admin.php');
        } else {
            header('Location: ../dashboard/dashboard_employee.php');
        }
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!-- HTML LOGIN PAGE -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - StartUp Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card shadow p-4" style="width: 400px;">
    <div class="text-center mb-4">
        <h2>StartUp Manager</h2>
        <p class="text-muted">Connectez-vous à votre compte</p>
    </div>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" placeholder="Votre nom d'utilisateur" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="Votre mot de passe" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-2">Se connecter</button>

        <div class="d-flex justify-content-between mt-3">
            <a href="register.php" class="btn btn-outline-success w-45">Créer un compte</a>
            <a href="login_admin.php" class="btn btn-outline-dark w-45">Connexion Admin</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
