
<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

try {

    $stmt = $pdo->query(
        "SELECT id, name, email, age FROM students ORDER BY id DESC"
    );

    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "students" => $students
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Мәліметтерді алу қатесі"
    ], JSON_UNESCAPED_UNICODE);

}

?>
