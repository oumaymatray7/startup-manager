<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StartUp Manager</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Ton propre fichier CSS si besoin -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">

<!-- Navbar commune -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="../dashboard/dashboard_admin.php">StartUp Manager</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../employee_management/list.php">Employés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../project_management/list.php">Projets</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="../account_management/profile.php">Mon Compte</a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-outline-light ms-2" href="../auth/logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Début du Contenu principal -->
<div class="container mt-5">
