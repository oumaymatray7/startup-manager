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

<!-- Section Comment StartUp Manager aide les PME -->
<section id="pme" class="services section light-background">
  <div class="container section-title" data-aos="fade-up">
    <h2>Comment StartUp Manager aide les PME</h2>
    <p>Nous accompagnons les petites et moyennes entreprises dans leur transformation numérique et leur organisation quotidienne.</p>
  </div>

  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-clipboard-data"></i></div>
          <h3>Suivi en Temps Réel</h3>
          <p>Suivez l'avancement de vos projets, tâches et objectifs commerciaux en temps réel via un tableau de bord intuitif.</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-people"></i></div>
          <h3>Collaboration Facilitée</h3>
          <p>Partagez des documents, assignez des responsabilités et échangez facilement au sein d'équipes même distantes.</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-bar-chart-line"></i></div>
          <h3>Productivité Accrue</h3>
          <p>Automatisez les rappels, priorisez vos tâches critiques et améliorez votre efficacité globale avec notre système intelligent.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section Avis Clients -->
<section id="testimonials" class="testimonials section dark-background">
  <div class="container section-title" data-aos="fade-up">
    <h2>Ce que disent nos clients</h2>
    <p>Des dizaines de PME nous font confiance pour gérer leurs projets et stimuler leur croissance !</p>
  </div>

  <div class="container">
    <div class="swiper testimonials-slider" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper-wrapper">

        <div class="swiper-slide testimonial-item">
          <div class="testimonial-content">
            <p>Grâce à StartUp Manager, nous avons augmenté notre productivité de 35% en 3 mois. Un outil indispensable pour les startups modernes !</p>
            <h4>Claire M.</h4>
            <h5>Fondatrice de TechWave</h5>
          </div>
        </div>

        <div class="swiper-slide testimonial-item">
          <div class="testimonial-content">
            <p>Nous avons pu organiser nos projets et éviter les retards. Interface intuitive et équipe de support ultra-réactive.</p>
            <h4>Marc L.</h4>
            <h5>Directeur de PME Logistics</h5>
          </div>
        </div>

        <div class="swiper-slide testimonial-item">
          <div class="testimonial-content">
            <p>StartUp Manager a changé notre manière de travailler. Tout est centralisé, fluide et simple à utiliser.</p>
            <h4>Sophie R.</h4>
            <h5>Manager chez EasyBuild</h5>
          </div>
        </div>

      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>

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
