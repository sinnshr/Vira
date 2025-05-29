<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit;
}
unset($_SESSION['cart']);
echo "خرید شما با موفقیت انجام شد.";
?>