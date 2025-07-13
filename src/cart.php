<?php
declare(strict_types=1);
require_once 'db.php';

function addToCart(int $book_id): bool
{
    if (!isset($_SESSION['id']))
        return false;
    $user_id = $_SESSION['id'];
    $pdo = dbConnect();

    $stmt = $pdo->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND book_id = ?");
    $stmt->execute([$user_id, $book_id]);
    $exists = $stmt->fetchColumn();

    if ($exists !== false) {
        $stmt = $pdo->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$user_id, $book_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO cart_items (user_id, book_id, quantity) VALUES (?, ?, 1)");
        $stmt->execute([$user_id, $book_id]);
    }

    $_SESSION['cart'][$book_id] = ($_SESSION['cart'][$book_id] ?? 0) + 1;
    return true;
}

function fetchCart(int $user_id): array
{
    $pdo = dbConnect();
    $stmt = $pdo->prepare("
        SELECT b.*, ci.quantity
        FROM cart_items ci
        JOIN books b ON ci.book_id = b.book_id
        WHERE ci.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $cart_items = [];
    foreach ($stmt as $row) {
        $cart_items[$row['book_id']] = $row;
    }
    return $cart_items;
}

function deleteFromCart(int $book_id): bool
{
    if (!isset($_SESSION['id']))
        return false;
    $user_id = $_SESSION['id'];
    $pdo = dbConnect();
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ? AND book_id = ?");
    $stmt->execute([$user_id, $book_id]);
    unset($_SESSION['cart'][$book_id]);
    return true;
}

function changeCartQuantity(int $book_id, int $delta): void
{
    if (!isset($_SESSION['id']))
        return;
    $user_id = $_SESSION['id'];
    $pdo = dbConnect();

    $stmt = $pdo->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND book_id = ?");
    $stmt->execute([$user_id, $book_id]);
    $current_quantity = (int) ($stmt->fetchColumn() ?: 0);
    $new_quantity = max(1, $current_quantity + $delta);

    $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND book_id = ?");
    $stmt->execute([$new_quantity, $user_id, $book_id]);
    $_SESSION['cart'][$book_id] = $new_quantity;
}

function finalizeCartToOrder(int $user_id)
{
    $pdo = dbConnect();
    $cart_items = fetchCart($user_id);
    if (!$cart_items)
        return false;

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, created_at, status) VALUES (?, NOW(), 'در حال پردازش')");
        $stmt->execute([$user_id]);
        $order_id = $pdo->lastInsertId();

        $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart_items as $item) {
            $stmt_item->execute([
                $order_id,
                $item['book_id'],
                $item['quantity'],
                $item['price']
            ]);
        }

        $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?")->execute([$user_id]);
        $pdo->commit();
        unset($_SESSION['cart']);
        return $order_id;
    } catch (Exception $e) {
        error_log("Order creation failed: " . $e->getMessage());
        $pdo->rollBack();
        return false;
    }
}