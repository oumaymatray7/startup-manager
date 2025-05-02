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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Thème personnalisé inspiré de CoManage -->
    <link rel="stylesheet" href="../assets/css/theme-comanage.css">

    <!-- Optionnel : favicon -->
    <link rel="icon" href="../assets/img/favicon.png" type="image/png">
</head>
<body>

<!-- Barre de navigation supérieure -->
<nav class="navbar navbar-expand-lg" style="background-color: #1c1f3f;">
    <div class="container-fluid">
        <a class="navbar-brand text-white fw-bold" href="../dashboard/dashboard_admin.php">StartUp Manager</a>

        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../employee_management/list.php"> Employés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../project_management/list.php"> Projets</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="../account_management/profile.php"> Mon Compte</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light ms-3" href="../auth/logout.php"> Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenu principal -->
<div class="container mt-5">
