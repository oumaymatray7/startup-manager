<?php
include '../includes/db.php';
include '../includes/session.php';
include '../includes/functions.php';

checkLogin();

$stmt = $pdo->prepare('SELECT username, email, phone, photo, role FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    redirectWithMessage('../auth/login.php', 'error', 'Utilisateur introuvable.');
}

include '../includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">👤 Mon Profil</h1>
        <a href="../dashboard/dashboard_<?php echo htmlspecialchars($_SESSION['role']); ?>.php" class="btn btn-outline-dark">← Retour au Dashboard</a>
    </div>

    <div class="card shadow-sm border-0 profile-card mb-4">
        <div class="card-header">
            📌 Informations Personnelles
        </div>
        <div class="card-body">

            <div class="text-center mb-4">
                <?php if (!empty($user['photo']) && file_exists('../assets/img/profiles/' . $user['photo'])) : ?>
                    <img src="../assets/img/profiles/<?php echo htmlspecialchars($user['photo']); ?>?v=<?= time(); ?>" alt="Photo de profil" class="rounded-circle shadow-sm" width="150" height="150">
                <?php else : ?>
                    <img src="../assets/img/profiles/default.png" alt="Photo par défaut" class="rounded-circle shadow-sm" width="150" height="150">
                <?php endif; ?>
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>👤 Nom d'utilisateur :</strong> <?php echo htmlspecialchars($user['username']); ?></li>
                <li class="list-group-item"><strong>📧 Email :</strong> <?php echo htmlspecialchars($user['email']); ?></li>
                <li class="list-group-item"><strong>📱 Téléphone :</strong> <?php echo htmlspecialchars($user['phone']); ?></li>
                <li class="list-group-item"><strong>🗭️ Rôle :</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></li>
            </ul>
        </div>
    </div>

    <div class="row g-3 profile-actions">
        <div class="col-md-6">
            <a href="edit_profile.php" class="btn btn-primary w-100">✏️ Modifier Mon Profil</a>
        </div>
        <div class="col-md-6">
            <a href="change_password.php" class="btn btn-warning w-100">🔒 Changer Mot de Passe</a>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
