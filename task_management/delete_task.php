<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérification : seul un admin peut accéder
checkAdmin();

// Vérifier que l'ID de la tâche est passé et est un nombre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Supprimer la tâche
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$id]);

    // Rediriger vers la liste des projets (ou page précédente) avec message
    redirectWithMessage('../project_management/list.php', 'success', 'Tâche supprimée avec succès');
} else {
    redirectWithMessage('../project_management/list.php', 'error', 'ID de tâche invalide');
}
?>
