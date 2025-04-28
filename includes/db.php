<?php
// Définir les constantes de connexion
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'startup_manager');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

try {
    // Création de la connexion PDO
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Affiche les erreurs SQL
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Retourne les résultats en tableau associatif
            PDO::ATTR_EMULATE_PREPARES => false, // Sécurise contre les injections SQL
        ]
    );
} catch (PDOException $e) {
    // Message d'erreur en cas de problème de connexion
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
?>
