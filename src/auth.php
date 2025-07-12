<?php
declare(strict_types=1);
session_start();
require_once 'db.php';

function login(string $username, string $password): bool
{
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    return false;
}

function logout(): void
{
    session_unset();
    session_destroy();
    header("Location: /index.php");
    exit();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['id']);
}

function getUser(): ?array
{
    if (!isLoggedIn())
        return null;
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['id']]);
    return $stmt->fetch() ?: null;
}

function getUserPassword(int $userId): ?string
{
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    $row = $stmt->fetch();
    return $row['password'] ?? null;
}

function updateUserPassword(int $userId, string $hashedPassword): bool
{
    $pdo = dbConnect();
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
    return $stmt->execute([':password' => $hashedPassword, ':id' => $userId]);
}

function loginOrRegisterWithGoogle(string $google_id, string $email, string $name): bool
{
    $pdo = dbConnect();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = :google_id");
    $stmt->execute([':google_id' => $google_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET google_id = :google_id WHERE id = :id");
        $stmt->execute([':google_id' => $google_id, ':id' => $user['id']]);
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    $stmt = $pdo->prepare("INSERT INTO users (username, email, google_id) VALUES (:username, :email, :google_id)");
    $success = $stmt->execute([
        ':username' => $name ?: $email,
        ':email' => $email,
        ':google_id' => $google_id
    ]);
    if ($success) {
        $newUserId = $pdo->lastInsertId();
        $_SESSION['id'] = $newUserId;
        $_SESSION['username'] = $name ?: $email;
        return true;
    }
    return false;
}