<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "خطا در ورود با حساب گوگل";

$msg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : "ورود با گوگل ناموفق بود.";
ob_start();
?>

<div class="flex justify-center items-center h-[90vh]">
    <div class="bg-yellow-50 border-2 border-red-400 text-red-700 p-12 rounded-lg text-center">
        <h2 class="text-2xl font-bold mb-4">خطا در ورود با گوگل</h2>
        <p class="mb-6"><?= $msg ?></p>
        <a href="login.php"
            class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-medium py-2 px-4 rounded transition-colors duration-200 no-underline">
            بازگشت به صفحه ورود
        </a>
    </div>
</div>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>