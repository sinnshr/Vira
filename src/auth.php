<?php
session_start();
require_once 'db.php';
$pdo = dbConnect();

function login($username, $password)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

function logout()
{
    session_unset();
    session_destroy();
    header("Location: /index.php");
    exit();
}

function isLoggedIn()
{
    return isset($_SESSION['id']);
}

function getUser()
{
    global $pdo;
    if (isLoggedIn()) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['id']]);
        return $stmt->fetch();
    }
    return null;
}

function getUserPassword($userId)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $row = $stmt->fetch();
    return $row ? $row['password'] : null;
}

function updateUserPassword($userId, $hashedPassword)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    return $stmt->execute(['password' => $hashedPassword, 'id' => $userId]);
}
?>