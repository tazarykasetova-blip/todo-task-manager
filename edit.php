<?php
require 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("Қате ID!");
}

$stmt = $pdo->prepare(
    "SELECT * FROM students WHERE id = ?"
);
$stmt->execute([$id]);

$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Студент табылмады!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    $stmt = $pdo->prepare(
        "UPDATE students
         SET name = ?, email = ?, age = ?
         WHERE id = ?"
    );

    $stmt->execute([$name, $email, $age, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Студентті өңдеу</title>
</head>
<body>

<h1>Студент мәліметтерін өңдеу</h1>

<form method="POST">

    <input type="text" name="name"
           value="<?= htmlspecialchars($student['name']) ?>"
           required>
    <br><br>

    <input type="email" name="email"
           value="<?= htmlspecialchars($student['email']) ?>"
           required>
    <br><br>

    <input type="number" name="age"
           value="<?= htmlspecialchars($student['age']) ?>"
           min="1" required>
    <br><br>

    <button type="submit">Өзгерістерді сақтау</button>

</form>

<a href="index.php">Артқа қайту</a>

</body>
</html>