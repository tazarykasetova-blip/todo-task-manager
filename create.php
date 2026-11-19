<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    $stmt = $pdo->prepare(
        "INSERT INTO students (name, email, age)
         VALUES (:name, :email, :age)"
    );

    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':age' => $age
    ]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <title>Студент қосу</title>
</head>
<body>

<h1>Жаңа студент қосу</h1>

<form method="POST">

    <input type="text" name="name"
           placeholder="Аты-жөні" required>
    <br><br>

    <input type="email" name="email"
           placeholder="Email" required>
    <br><br>

    <input type="number" name="age"
           placeholder="Жасы" min="1" required>
    <br><br>

    <button type="submit">Сақтау</button>

</form>

<a href="index.php">Артқа қайту</a>

</body>
</html>