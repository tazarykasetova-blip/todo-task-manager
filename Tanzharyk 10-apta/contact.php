<?php 
include 'includes/header.php'; 

// Өзгермелі айнымалылар
$name = $email = $message = '';
$errors = [];
$success_message = '';

// Form жіберілгенін тексеру (POST сұранысы)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Деректерді тазалау (XSS сүзгісі)
    $name = trim(htmlspecialchars($_POST['name'] ?? ''));
    $email = trim(htmlspecialchars($_POST['email'] ?? ''));
    $message = trim(htmlspecialchars($_POST['message'] ?? ''));

    // 2.Серверлік Валидация
    if (empty($name)) {
        $errors[] = "Аты-жөніңізді енгізіңіз.";
    } elseif (mb_strlen($name) < 2) {
        $errors[] = "Аты-жөні кемінде 2 таңбадан тұруы керек.";
    }

    if (empty($email)) {
        $errors[] = "Электрондық поштаны енгізіңіз.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Электрондық пошта пішімі қате (мысалы: user@domain.com).";
    }

    if (empty($message)) {
        $errors[] = "Хабарлама мәтінін жазыңыз.";
    } elseif (mb_strlen($message) < 10) {
        $errors[] = "Хабарлама кемінде 10 таңбадан тұруы керек.";
    }

    // 3. Қате болмаса — Сәтті нәтиже
    if (empty($errors)) {
        $success_message = "Рақмет, {$name}! Хабарламаңыз сәтті жіберілді.";
        // Тізімді тазалау
        $name = $email = $message = '';
    }
}
?>

<div class="form-card">
    <h2 style="margin-bottom: 1.5rem; text-align: center;">Кері байланыс</h2>

    <!-- Қателерді шығару -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul style="margin-left: 1.2rem;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Сәтті хабарлама шығару -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <form action="contact.php" method="POST" novalidate>
        <div class="form-group">
            <label for="name">Толық аты-жөніңіз</label>
            <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>" placeholder="Асан Әлиев">
        </div>

        <div class="form-group">
            <label for="email">Электронды пошта</label>
            <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="example@mail.com">
        </div>

        <div class="form-group">
            <label for="message">Хабарламаңыз</label>
            <textarea id="message" name="message" class="form-control" placeholder="Сұрағыңызды немесе пікіріңізді қалдырыңыз..."><?php echo $message; ?></textarea>
        </div>

        <button type="submit" class="btn">Жіберу</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>


