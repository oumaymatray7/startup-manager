<?php
$total = count($tasks);
$done = count($completed_tasks);
$progress = $total > 0 ? round(($done / $total) * 100) : 0;
?>

<div class="mb-4">
  <div class="alert alert-light shadow-sm text-center">
    <h5 class="mb-2">📊 Statistiques Personnelles</h5>
    <p class="mb-1">Tâches complétées : <strong><?= $done ?></strong> / <?= $total ?></p>
    <div class="progress" style="height: 20px;">
      <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
        <?= $progress ?>%
      </div>
    </div>
  </div>
</div>
