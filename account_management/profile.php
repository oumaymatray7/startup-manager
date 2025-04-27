<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est connecté
checkLogin();

// Charger les informations de l'utilisateur connecté
$stmt = $pdo->prepare('SELECT username, email, phone, photo, role FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirectWithMessage('../auth/login.php', 'error', 'Utilisateur introuvable.');
}
?>

<?php include '../includes/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Mon Profil</h1>
    <a href="../dashboard/dashboard_<?php echo htmlspecialchars($_SESSION['role']); ?>.php" class="btn btn-secondary">← Retour au Dashboard</a>
</div>

<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Informations Personnelles</h5>
    </div>
    <div class="card-body">

        <div class="text-center mb-4">
            <?php if (!empty($user['photo']) && file_exists('../assets/img/profiles/' . $user['photo'])) : ?>
                <img src="../assets/img/profiles/<?php echo htmlspecialchars($user['photo']); ?>" alt="Photo de profil" class="rounded-circle" width="150" height="150">
            <?php else : ?>
                <img src="../assets/img/profiles/default.png" alt="Photo par défaut" class="rounded-circle" width="150" height="150">
            <?php endif; ?>
        </div>

        <p><strong>Nom d'utilisateur :</strong> <?php echo htmlspecialchars($user['username']); ?></p>
        <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        <p><strong>Rôle :</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
    </div>
</div>

<div class="d-flex gap-3">
    <a href="edit_profile.php" class="btn btn-primary w-50">Modifier Mon Profil</a>
    <a href="change_password.php" class="btn btn-warning w-50">Changer Mot de Passe</a>
</div>

<?php include '../includes/footer.php'; ?>
