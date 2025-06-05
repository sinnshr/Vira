<?php
require_once 'db.php';
$pdo = dbConnect();
function addToCart($book_id)
{
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        global $pdo;

        // Check if item already exists
        $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$user_id, $book_id]);

        // if exists, increase quantity
        if ($stmt->rowCount() > 0) {
            // Update quantity
            $stmt = $pdo->prepare("UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = ? AND book_id = ?");
        } else {
        // if not, insert new item
            $stmt = $pdo->prepare("INSERT INTO cart_items (user_id, book_id, quantity) VALUES (?, ?, 1)");
        }
        $stmt->execute([$user_id, $book_id]);
    }

    // Update session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][$book_id] = ($_SESSION['cart'][$book_id] ?? 0) + 1;

    return true;
}
function fetchCart($user_id)
{
    global $pdo;
    $cart_items = [];

    $stmt = $pdo->prepare("
        SELECT b.*, ci.quantity
        FROM cart_items ci
        JOIN books b ON ci.book_id = b.book_id
        WHERE ci.user_id = ?
    ");
    $stmt->execute([$user_id]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cart_items[$row['book_id']] = $row;
    }

    return $cart_items;
}

function deleteFromCart($book_id) : bool {
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        global $pdo;

        // Remove item from database
        $stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$user_id, $book_id]);

        // Update session
        if (isset($_SESSION['cart'][$book_id])) {
            unset($_SESSION['cart'][$book_id]);
        }
        return true;
    }
    return false;
}