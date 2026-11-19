<?php
require 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die("Қате ID!");
}

$stmt = $pdo->prepare(
    "DELETE FROM students WHERE id = ?"
);

$stmt->execute([$id]);

header("Location: index.php");
exit;
?>