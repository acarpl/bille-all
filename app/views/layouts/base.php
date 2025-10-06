<?php
// app/views/layouts/base.php

// Extract data untuk digunakan di layout
extract($data ?? []);
?>

<?php include 'header.php'; ?>

<?php include 'navbar.php'; ?>

<main style="min-height: calc(100vh - 200px);">
    <div class="container">
        <?php echo $content; ?>
    </div>
</main>

<?php include 'footer.php'; ?>