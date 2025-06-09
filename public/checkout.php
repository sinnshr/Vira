<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "ویرا - تکمیل خرید";
ob_start();
if (!isset($_SESSION['id'])) {
    header("Location: public/login.php");
    exit;
}
unset($_SESSION['cart']);
?>
<div class="flex flex-col items-center justify-center h-screen -mt-16">
    <div class="text-5xl text-green-500 mb-4">
        <i class="fa-regular fa-circle-check text-[#5F6F52]"></i>
    </div>
    <div class="text-2xl font-semibold text-gray-800 mb-6">خرید شما با موفقیت انجام شد.</div>
    <a href="/public/books.php"
        class="inline-block px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-md text-lg transition">بازگشت
        به صفحه اصلی</a>
</div>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>