<?php
include '../includes/db.php';
session_start();

$error = "";
$success = "";

// Tester quand formulaire envoyé
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND role = "admin"');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $success = "Mot de passe CORRECT ✅";
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'admin';
        } else {
            $error = "Mot de passe INCORRECT ❌";
        }
    } else {
        $error = "Aucun utilisateur Admin trouvé avec ce username ❌";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Connexion Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card shadow p-4" style="width:400px;">
    <h2 class="text-center mb-4">Test Connexion Admin</h2>

    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" placeholder="admin" required>
        </div>

        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="Votre mot de passe" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Tester Connexion</button>
    </form>
</div>

</body>
</html>
