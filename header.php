<?php
  include 'includes/db.php';
  include 'includes/session.php';

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

<header id="header" class="header d-flex align-items-center sticky-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <!-- Logo -->
    <a href="index.php" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="StartUp Manager Logo" class="logo-img">
      <h1 class="sitename">StartUp Manager</h1>
    </a>

    <!-- Navigation Menu (avant la connexion) -->
    <?php if (!isset($_SESSION['user_id'])): ?>
      <nav id="navmenu" class="navmenu">
        <ul class="d-flex list-unstyled m-0">
          <li><a href="#hero" class="nav-link">Accueil</a></li>
          <li><a href="#about" class="nav-link">À propos</a></li>
          <li><a href="auth/login.php" class="btn btn-primary btn-sm ms-3">Se connecter</a></li>
        </ul>
        <!-- Mobile Nav Icon -->
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    <?php else: ?>
      <!-- Navigation Menu (si l'utilisateur est connecté) -->
      <nav id="navmenu" class="navmenu">
        <ul class="d-flex list-unstyled m-0">
          <li><a href="#hero" class="nav-link">Accueil</a></li>
          <li><a href="#about" class="nav-link">À propos</a></li>
          <li><a href="dashboard/<?php echo $_SESSION['role']; ?>/index.php" class="btn btn-secondary btn-sm ms-3">Mon tableau de bord</a></li>
          <li><a href="auth/logout.php" class="btn btn-danger btn-sm ms-3">Se déconnecter</a></li>
        </ul>
        <!-- Mobile Nav Icon -->
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    <?php endif; ?>
  </div>
</header>

<!-- Mobile Navigation -->
<div class="mobile-nav d-lg-none">
  <div class="container d-flex justify-content-between align-items-center py-2">
    <a href="index.php" class="logo">
      <img src="assets/img/logo.png" alt="StartUp Manager Logo" class="logo-img">
      <h1 class="sitename">StartUp Manager</h1>
    </a>
    <button class="mobile-nav-toggle btn btn-link">
      <i class="bi bi-list"></i>
    </button>
  </div>
  <nav id="mobile-nav" class="mobile-nav-menu">
    <ul>
      <li><a href="#hero" class="nav-link">Accueil</a></li>
      <li><a href="#about" class="nav-link">À propos</a></li>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <li><a href="auth/login.php" class="btn btn-primary btn-sm">Se connecter</a></li>
      <?php else: ?>
        <li><a href="dashboard/<?php echo $_SESSION['role']; ?>/index.php" class="btn btn-secondary btn-sm">Mon tableau de bord</a></li>
        <li><a href="auth/logout.php" class="btn btn-danger btn-sm">Se déconnecter</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</div>

<!-- CSS for styling -->
<style>
  /* Styling for header and logo */
  .logo {
    display: flex;
    align-items: center;
  }

  .logo-img {
    max-height: 40px;
    margin-right: 10px;
  }

  .sitename {
    font-size: 24px;
    font-weight: bold;
    color: var(--primary-color);
  }

  /* Navigation menu for large screens */
  .navmenu ul {
    display: flex;
    align-items: center;
  }

  .navmenu li {
    margin-left: 20px;
  }

  .nav-link {
    text-decoration: none;
    color: var(--default-color);
    font-size: 16px;
    font-weight: 500;
    transition: color 0.3s ease;
  }

  .nav-link:hover {
    color: var(--accent-color);
  }

  .btn-primary {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    color: #fff;
    font-weight: 600;
  }

  .btn-primary:hover {
    background-color: var(--accent-hover-color);
    border-color: var(--accent-hover-color);
  }

  .btn-danger {
    background-color: var(--danger-color);
    border-color: var(--danger-color);
    color: #fff;
    font-weight: 600;
  }

  .btn-danger:hover {
    background-color: var(--danger-hover-color);
    border-color: var(--danger-hover-color);
  }

  /* Mobile Nav */
  .mobile-nav-menu {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    background-color: #fff;
    width: 100%;
    height: 100vh;
    padding-top: 60px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  }

  .mobile-nav-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
    text-align: center;
  }

  .mobile-nav-menu li {
    margin-bottom: 20px;
  }

  .mobile-nav-toggle {
    font-size: 30px;
    color: var(--default-color);
  }

  /* Mobile nav toggle visibility */
  .mobile-nav.active .mobile-nav-menu {
    display: block;
  }

  /* Mobile Menu Background */
  .mobile-nav {
    display: none;
  }

  @media (max-width: 1199px) {
    .mobile-nav {
      display: block;
    }
  }

  /* Hide desktop site name and logo on mobile */
  .d-none.d-xl-block {
    display: none !important;
  }
</style>

<!-- JS for Mobile Navigation Toggle -->
<script>
  document.querySelector('.mobile-nav-toggle').addEventListener('click', function() {
    document.querySelector('.mobile-nav').classList.toggle('active');
  });
</script>
