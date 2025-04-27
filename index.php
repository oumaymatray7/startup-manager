<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclure le fichier session.php une seule fois pour gérer la session et les rôles
include_once 'includes/session.php';

// Si l'utilisateur est déjà connecté, on le redirige vers le dashboard approprié
if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: dashboard/dashboard_admin.php');
        exit();
    } elseif ($_SESSION['role'] === 'employee') {
        header('Location: dashboard/dashboard_employee.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>StartUp Manager</title>
    
    <!-- Favicon -->
    <link href="assets/img/favicon.png" rel="icon">
    
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    
    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

<!-- Header -->
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <!-- Logo -->
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="StartUp Manager Logo" class="logo-img">
            <h1 class="sitename">StartUp Manager</h1>
        </a>

        <!-- Navigation Menu -->
        <nav id="navmenu" class="navmenu">
            <ul class="d-flex list-unstyled m-0">
                <li><a href="#hero" class="nav-link">Accueil</a></li>
                <li><a href="#about" class="nav-link">À propos</a></li>
                <li><a href="auth/login.php" class="btn btn-primary btn-sm ms-3">Se connecter</a></li>
            </ul>
            <!-- Mobile Nav Icon -->
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>

<main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background" style="background-color: #333;">
        <div class="container d-flex flex-column align-items-center justify-content-center text-center">
            <h2>Bienvenue sur <strong>StartUp Manager</strong></h2>
            <p>Optimisez la gestion de vos projets et tâches facilement !</p>
            <a href="auth/login.php" class="btn btn-primary mt-3">Commencer</a>
        </div>
    </section>

    <!-- Section À propos -->
    <section id="about" class="about section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2>À propos de StartUp Manager</h2>
                    <p class="mt-4">
                        StartUp Manager est une plateforme simple et puissante pour gérer vos projets, assigner des tâches, suivre l'avancement et collaborer efficacement avec votre équipe.
                        Que vous soyez une startup, une entreprise ou un entrepreneur indépendant, notre outil vous aide à mieux organiser votre travail au quotidien.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Nos Services</h2>
            <p>StartUp Manager vous permet de gérer vos projets et de collaborer efficacement avec votre équipe.</p>
        </div>

        <div class="container">
            <div class="row gy-4">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-activity"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Gestion des Projets</h3>
                        </a>
                        <p>Suivez l'évolution de vos projets et assurez-vous qu'ils soient réalisés à temps.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-broadcast"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Gestion des Tâches</h3>
                        </a>
                        <p>Assignez et suivez les tâches de votre équipe, tout en garantissant des délais respectés.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="icon">
                            <i class="bi bi-easel"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Collaboration en Équipe</h3>
                        </a>
                        <p>Favorisez une collaboration fluide au sein de votre équipe avec un tableau de bord centralisé.</p>
                    </div>
                </div><!-- End Service Item -->

            </div>
        </div>
    </section><!-- /Services Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Contactez-Nous</h2>
            <p>Si vous avez des questions ou souhaitez en savoir plus sur StartUp Manager, contactez-nous ci-dessous.</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <form action="forms/contact.php" method="post" class="php-email-form">
                <div class="row gy-4">

                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Votre nom" required=""/>
                    </div>

                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" placeholder="Votre email" required=""/>
                    </div>

                    <div class="col-md-12">
                        <textarea class="form-control" name="message" rows="6" placeholder="Votre message" required=""></textarea>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit">Envoyer le message</button>
                    </div>

                </div>
            </form><!-- End Contact Form -->
        </div>
    </section><!-- /Contact Section -->

</main>

<footer id="footer" class="footer accent-background">
    <div class="container text-center">
        <p>© 2025 <strong>StartUp Manager</strong> | Tous droits réservés</p>
    </div>
</footer>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/typed.js/typed.umd.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>

</body>
</html>
