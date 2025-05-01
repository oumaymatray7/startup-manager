<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté
checkLogin();

$success = "";
$error = "";

// Charger les informations actuelles de l'utilisateur
$stmt = $pdo->prepare('SELECT username, email, phone, photo FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirectWithMessage('../auth/login.php', 'error', 'Utilisateur introuvable.');
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $photo = $user['photo']; // garder la photo actuelle par défaut

    // Gestion de l'upload de photo
    if (!empty($_FILES['photo']['name'])) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

        // Dossier d'upload correct
        $upload_dir = '../assets/img/profiles/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (in_array($file_extension, $allowed_extensions)) {
            if ($_FILES['photo']['size'] <= 2 * 1024 * 1024) {
                $photo_name = uniqid('user_', true) . '.' . $file_extension;
                $photo_path = $upload_dir . $photo_name;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
                    $photo = $photo_name;
                } else {
                    $error = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $error = "L'image dépasse la taille maximale autorisée (2 Mo).";
            }
        } else {
            $error = "Format d'image non autorisé. (jpg, jpeg, png, gif uniquement)";
        }
    }

    if (empty($error)) {
        $stmt = $pdo->prepare('UPDATE users SET email = ?, phone = ?, photo = ? WHERE id = ?');
        $stmt->execute([$email, $phone, $photo, $_SESSION['user_id']]);

        $success = "Profil mis à jour avec succès.";

        // Recharger les infos mises à jour
        $stmt = $pdo->prepare('SELECT username, email, phone, photo FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Modifier Mon Profil</h1>
    <a href="../account_management/profile.php" class="btn btn-secondary">← Retour au Profil</a>
</div>

<?php if (!empty($error)) : ?>
    <?php showError($error); ?>
<?php endif; ?>

<?php if (!empty($success)) : ?>
    <?php showSuccess($success); ?>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>

    <div class="mb-3">
        <label>Téléphone</label>
        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
    </div>

    <div class="mb-3">
        <label>Photo de Profil (optionnel)</label><br>
        <div class="text-center mb-3">
            <?php if (!empty($user['photo']) && file_exists('../assets/img/profiles/' . $user['photo'])) : ?>
                <img src="../assets/img/profiles/<?php echo htmlspecialchars($user['photo']); ?>?v=<?php echo time(); ?>" alt="Photo actuelle" width="100" class="rounded-circle">
            <?php else : ?>
                <img src="../assets/img/profiles/default.png" alt="Photo par défaut" width="100" class="rounded-circle">
            <?php endif; ?>
        </div>
        <input type="file" name="photo" class="form-control mt-2">
        <small class="text-muted">Formats acceptés : jpg, jpeg, png, gif. Taille max : 2 Mo.</small>
    </div>

    <button type="submit" class="btn btn-primary w-100">Enregistrer les modifications</button>
</form>

<?php include '../includes/footer.php'; ?>
