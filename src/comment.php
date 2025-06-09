<?php
require_once 'db.php';
function addComment()
{
    $name = $_POST['name'];
    $comment = $_POST['comment'];

    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO comments (name, comment) VALUES (?, ?)");
    if (!$stmt) {
        return false;
    }
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $comment);
    $success = $stmt->execute();
    return $success;
}

?>