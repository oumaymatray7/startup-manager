<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérification si l'utilisateur est connecté, redirige vers dashboard
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: ../dashboard/dashboard_admin.php');
        exit();
    } elseif ($_SESSION['role'] === 'employee') {
        header('Location: ../dashboard/dashboard_employee.php');
        exit();
    }
}
?>
