<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

checkLogin();

if (isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['status'])) {
    $task_id = intval($_GET['id']);
    $new_status = sanitizeInput($_GET['status']);

    $stmt = $pdo->prepare('UPDATE tasks SET status = ? WHERE id = ?');
    $stmt->execute([$new_status, $task_id]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    header('Location: ../dashboard/dashboard_employee.php');
    exit();
}
?>
