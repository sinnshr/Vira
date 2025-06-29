<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "ویرا - تکمیل خرید";
ob_start();
if (!isset($_SESSION['id'])) {
    header("Location: /login.php");
    exit;
}

// Check if cart is empty before finalizing order
$cart_items = fetchCart($_SESSION['id']);
if (empty($cart_items)) {
    $order_id = false;
    $order_error = "سبد خرید شما خالی است.";
} else {
    // تبدیل سبد خرید به سفارش
    $order_id = finalizeCartToOrder($_SESSION['id']);
    $order_error = null;
    if (!$order_id) {
        $order_error = "خطا در ثبت سفارش. لطفاً دوباره تلاش کنید.";
    }
}
?>
<div class="flex flex-col items-center justify-center h-screen -mt-16">
    <?php if ($order_id): ?>
        <div class="text-5xl text-green-500 mb-4">
            <i class="fa-regular fa-circle-check text-[#5F6F52]"></i>
        </div>
        <div class="text-2xl font-semibold text-gray-800 mb-6">خرید شما با موفقیت انجام شد.</div>
        <div class="mb-4 text-lg text-gray-700">
            شماره سفارش: <span class="font-bold text-[#5F6F52]"><?= $order_id ?></span>
        </div>
        <a href="/orders.php"
            class="inline-block px-6 py-2 bg-[#A9B388] hover:bg-[#5F6F52] text-white rounded-md text-lg transition">مشاهده
            تاریخچه سفارش‌ها</a>
        <a href="/books.php"
            class="inline-block px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-md text-lg transition mt-2">بازگشت
            به صفحه اصلی</a>
    <?php else: ?>
        <div class="text-2xl text-red-600 mb-4">
            <?= htmlspecialchars($order_error) ?>
        </div>
        <a href="/cart.php"
            class="inline-block px-6 py-2 bg-[#A9B388] hover:bg-[#5F6F52] text-white rounded-md text-lg transition">بازگشت
            به سبد خرید</a>
    <?php endif; ?>
</div>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>