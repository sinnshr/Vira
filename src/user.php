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

function getUserOrders($user_id)
{
    $conn = dbConnect();
    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function getOrderDetails($order_id, $user_id)
{
    $conn = dbConnect();
    // fetch order
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
    $stmt->execute([$order_id, $user_id]);
    $order = $stmt->fetch();
    if (!$order)
        return null;

    // fetch order items
    $stmt = $conn->prepare("SELECT oi.*, b.title, b.author, b.image_url FROM order_items oi JOIN books b ON oi.book_id = b.book_id WHERE oi.order_id = ?");
    $stmt->execute([$order_id]);
    $items = $stmt->fetchAll();

    $order['items'] = $items;
    return $order;
}
?>