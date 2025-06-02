<?php
require_once 'db.php';

function createUser($username, $password, $email)
{
    $conn = dbConnect();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $hashedPassword, $email]);
}

function getUserById($id)
{
    $conn = dbConnect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function updateUser($id, $username, $email)
{
    $conn = dbConnect();
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    return $stmt->execute([$username, $email, $id]);
}

function deleteUser($id)
{
    $conn = dbConnect();
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}

function getUserByUsername($username)
{
    $conn = dbConnect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch();
}
?>