<?php
// Vérifier si une session est déjà active avant d'en démarrer une nouvelle
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérification de la connexion pour rediriger en fonction du rôle
function checkAdmin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../dashboard/dashboard_employee.php');
        exit();
    }
}

function checkEmployee() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
        header('Location: ../dashboard/dashboard_admin.php');
        exit();
    }
}

if (!function_exists('checkLogin')) {
    function checkLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../auth/login.php');
            exit();
        }
    }
}
?>
