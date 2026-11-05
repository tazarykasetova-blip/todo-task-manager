<?php include 'includes/header.php'; ?>

<section class="hero">
    <h1>PHP Серверлік Басқару Жүйесі</h1>
    <p>PHP арқылы модульдік сәулет құру және деректерді серверде қауіпсіз өңдеу үлгісі.</p>
    
    <?php
    // $_GET параметрін тексеру
    $category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : 'негізгі';
    ?>
    
    <div style="margin-top: 1.5rem; background: var(--card-bg); display: inline-block; padding: 0.5rem 1.5rem; border-radius: 20px;">
        Тандалған санат (GET сұранысы): <strong><?php echo $category; ?></strong>
    </div>
</section>

<?php include 'includes/footer.php'; ?>