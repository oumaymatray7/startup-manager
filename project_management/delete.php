<?php
include '../includes/db.php';
include '../includes/session.php';

// Vérification : seul un administrateur peut accéder
checkAdmin();

// Vérifier si l'ID est passé et est un nombre
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Supprimer le projet
    $stmt = $pdo->prepare('DELETE FROM projects WHERE id = ?');
    $stmt->execute([$id]);

    // Rediriger vers la liste avec un message de succès
    header('Location: list.php?success=Projet supprimé avec succès');
    exit();
} else {
    // Rediriger avec un message d'erreur si l'ID est invalide
    header('Location: list.php?error=ID de projet invalide');
    exit();
}
?>
