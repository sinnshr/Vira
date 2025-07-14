<?php
declare(strict_types=1);
require_once 'db.php';

function addComment(): bool
{
    $name = $_POST['name'] ?? '';
    $comment = $_POST['comment'] ?? '';
    if ($name === '' || $comment === '')
        return false;

    $pdo = dbConnect();
    $stmt = $pdo->prepare("INSERT INTO comments (name, comment) VALUES (?, ?)");
    return $stmt->execute([$name, $comment]);
}
?>