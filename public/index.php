<?php
// Démarrer la session publique
include_once 'session.php';

// Importer le header
include_once 'header.php';
?>

<main class="main">

<!-- Hero Section -->
<section id="hero" class="hero section dark-background" style="background-color: #333;">
  <div class="container d-flex flex-column align-items-center justify-content-center text-center">
    <h2>Bienvenue sur <strong>StartUp Manager</strong></h2>
    <p>Optimisez la gestion de vos projets et tâches facilement !</p>
    <a href="../auth/login.php" class="btn btn-primary mt-3">Commencer</a>
  </div>
</section>

<!-- Section À propos -->
<section id="about" class="about section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <h2>À propos de StartUp Manager</h2>
        <p class="mt-4">
          StartUp Manager est une solution tout-en-un conçue pour simplifier la gestion de vos projets, optimiser la collaboration de vos équipes et assurer le suivi efficace de vos tâches.
          <br><br>
          Adapté aux startups, PME et entrepreneurs, notre plateforme centralise toutes vos activités pour maximiser votre productivité et favoriser votre croissance.
        </p>
      </div>
    </div>
  </div>
</section>
<?php include_once __DIR__ . '/services.php'; ?>





<?php include_once __DIR__ . '/testimonials.php'; ?>


<form action="contact.php" method="post" class="php-email-form">
    <div class="row gy-4">

        <div class="col-md-6">
            <input type="text" name="name" class="form-control" placeholder="Votre nom" required />
        </div>

        <div class="col-md-6">
            <input type="email" name="email" class="form-control" placeholder="Votre email" required />
        </div>

        <div class="col-md-12">
            <textarea name="message" class="form-control" rows="6" placeholder="Votre message" required></textarea>
        </div>

        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Envoyer le message</button>
        </div>

    </div>
</form>
<?php if (isset($_SESSION['contact_success'])): ?>
    <div class="alert alert-success text-center">
        <?= $_SESSION['contact_success']; unset($_SESSION['contact_success']); ?>
    </div>
<?php elseif (isset($_SESSION['contact_error'])): ?>
    <div class="alert alert-danger text-center">
        <?= $_SESSION['contact_error']; unset($_SESSION['contact_error']); ?>
    </div>
<?php endif; ?>


</main>

<?php
// Importer le footer
include_once 'footer.php';



?>

