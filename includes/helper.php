<?php
    function toPersianDigits($number) {
        $western = ['0','1','2','3','4','5','6','7','8','9',','];
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٬'];
        return str_replace($western, $persian, $number);
    }

    function addToCart($book_id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$book_id])) {
            $_SESSION['cart'][$book_id]++;
        } else {
            $_SESSION['cart'][$book_id] = 1;
        }
    }
?>