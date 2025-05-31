<?php
session_start();
if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id]++;
    } else {
        $_SESSION['cart'][$book_id] = 1;
    }
    header("Location: public/cart.php");
}
?>