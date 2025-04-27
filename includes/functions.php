<?php
// Fonction pour afficher un message de succès Bootstrap
function showSuccess($message) {
    if (!empty($message)) {
        echo '<div class="alert alert-success">' . htmlspecialchars($message) . '</div>';
    }
}

// Fonction pour afficher un message d'erreur Bootstrap
function showError($message) {
    if (!empty($message)) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
    }
}

// Fonction pour sécuriser une entrée utilisateur (XSS protection)
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Fonction pour rediriger avec un message GET
function redirectWithMessage($url, $type, $message) {
    header("Location: {$url}?{$type}=" . urlencode($message));
    exit();
}
?>
