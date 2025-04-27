<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté et Admin
checkAdmin();

// Vérifier que l'id est fourni dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Vérifier que l'utilisateur existe et est un employé
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ? AND role = "employee"');
    $stmt->execute([$id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($employee) {
        // Supprimer l'utilisateur
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);

        // Redirection après suppression
        header('Location: list.php');
        exit();
    } else {
        // Si l'employé n'existe pas
        header('Location: list.php?error=Employé introuvable');
        exit();
    }
} else {
    // Mauvaise URL sans id
    header('Location: list.php?error=ID invalide');
    exit();
}
?>
