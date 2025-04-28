<?php
// public/contact.php

// Inclure la connexion à la base de données
include_once '../includes/db.php';

// Démarrer la session si nécessaire
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['contact_error'] = "Veuillez remplir tous les champs.";
        header('Location: index.php#contact');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['contact_error'] = "Adresse email invalide.";
        header('Location: index.php#contact');
        exit();
    }

    try {
        // Préparer et insérer dans la base de données
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':message' => $message
        ]);

        // (Optionnel) Envoyer aussi un email
        /*
        $to = "votre@email.com"; 
        $subject = "Nouveau message de $name";
        $body = "Nom: $name\nEmail: $email\nMessage:\n$message";
        $headers = "From: $email";

        mail($to, $subject, $body, $headers);
        */

        $_SESSION['contact_success'] = "Votre message a été envoyé avec succès. Merci de nous avoir contactés.";
    } catch (PDOException $e) {
        $_SESSION['contact_error'] = "Erreur lors de l'enregistrement du message : " . $e->getMessage();
    }

    header('Location: index.php#contact');
    exit();
} else {
    header('Location: index.php');
    exit();
}
