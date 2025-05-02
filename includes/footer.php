<!-- Footer Professionnel -->
<footer class="text-white mt-5 py-4 shadow-sm" style="background-color: #1c1f3f;">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-6 text-md-start mb-3 mb-md-0">
                <h5 class="fw-bold mb-2">StartUp Manager</h5>
                <p class="mb-0 small text-light">Votre assistant intelligent pour gérer vos projets, équipes et tâches efficacement.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1 small text-muted">&copy; <?php echo date('Y'); ?> StartUp Manager. Tous droits réservés.</p>
                <a href="#" class="text-muted small me-3">Mentions légales</a>
                <a href="#" class="text-muted small">Confidentialité</a>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Tooltips init -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(t => new bootstrap.Tooltip(t));
  });
</script>

</body>
</html>
