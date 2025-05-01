<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

checkLogin();

if (isset($_GET['id'], $_GET['status']) && is_numeric($_GET['id'])) {
    $task_id = intval($_GET['id']);
    $new_status = ucfirst(strtolower(trim($_GET['status'])));  // ✅ CORRECT : récupération depuis $_GET

    $allowed_statuses = ['En cours', 'Terminée'];
    if (in_array($new_status, $allowed_statuses)) {

        // Vérification : la tâche appartient à l'utilisateur si c'est un employé
        if ($_SESSION['role'] === 'employee') {
            $stmt = $pdo->prepare('SELECT id FROM tasks WHERE id = ? AND assigned_to = ?');
            $stmt->execute([$task_id, $_SESSION['user_id']]);
            if (!$stmt->fetch()) {
                redirectWithMessage('../dashboard/dashboard_employee.php', 'error', 'Tâche non autorisée ou inexistante.');
            }
        }

        // Mise à jour du statut
        $stmt = $pdo->prepare('UPDATE tasks SET status = ? WHERE id = ?');
        $stmt->execute([$new_status, $task_id]);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

// Redirection par défaut
header('Location: ../dashboard/dashboard_employee.php');
exit;
