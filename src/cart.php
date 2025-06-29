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

function deleteFromCart($book_id): bool
{
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
function changeCartQuantity($book_id, $delta)
{
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        global $pdo;

        // Get current quantity
        $stmt = $pdo->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$user_id, $book_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $current_quantity = (int) $row['quantity'];
            $new_quantity = $current_quantity + (int) $delta;
            if ($new_quantity < 1) {
                $new_quantity = 1;
            }
            $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND book_id = ?");
            $stmt->execute([$new_quantity, $user_id, $book_id]);
            // Update session
            $_SESSION['cart'][$book_id] = $new_quantity;
        }
    }
}
function finalizeCartToOrder($user_id)
{
    global $pdo;
    $cart_items = fetchCart($user_id);
    if (empty($cart_items)) {
        return false;
    }

    $pdo->beginTransaction();
    try {
        // create new order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, created_at, status) VALUES (?, NOW(), 'در حال پردازش')");
        $stmt->execute([$user_id]);
        $order_id = $pdo->lastInsertId();

        // add items to order_items table
        $stmt_item = $pdo->prepare("INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart_items as $item) {
            $stmt_item->execute([
                $order_id,
                $item['book_id'],
                $item['quantity'],
                $item['price']
            ]);
        }

        // delete items from cart
        $stmt = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $pdo->commit();
        // delete cart from session
        unset($_SESSION['cart']);
        return $order_id;
    } catch (Exception $e) {
        error_log("Order creation failed: " . $e->getMessage());
        $pdo->rollBack();
        return false;
    }
}