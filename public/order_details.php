<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "ویرا - جزئیات سفارش";
if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
$order_id = $_GET['id'] ?? null;
$user_id = $_SESSION['id'];
$order = getOrderDetails($order_id, $user_id);

ob_start();
?>
<div class="max-w-3xl mx-auto px-4 py-10 mt-5">
    <?php if (!$order): ?>
        <div class="flex flex-col items-center justify-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mb-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <div class="text-xl text-red-600 font-semibold">سفارش مورد نظر یافت نشد.</div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h1 class="text-3xl font-bold text-[#4B6043] mb-6 text-center tracking-tight">جزئیات سفارش شماره
                <?= toPersianDigits($order['id']) ?>
            </h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="flex flex-col gap-2">
                    <span class="text-gray-500 font-semibold">تاریخ ثبت</span>
                    <span class="text-lg font-bold px-2 py-1 rounded bg-[#A9B388] text-white w-fit"
                        data-date="<?= date('Y-m-d', strtotime($order['created_at'])) ?>"></span>
                </div>
                <div class="flex flex-col gap-2">
                    <span class="text-gray-500 font-semibold">وضعیت</span>
                    <span
                        class="text-lg font-bold px-2 py-1 rounded bg-amber-100 text-amber-700 w-fit"><?= htmlspecialchars($order['status']) ?></span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-right border-separate border-spacing-y-2">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="py-3 px-2 text-gray-700">تصویر</th>
                            <th class="py-3 px-2 text-gray-700">عنوان کتاب</th>
                            <th class="py-3 px-2 text-gray-700">نویسنده</th>
                            <th class="py-3 px-2 text-gray-700">تعداد</th>
                            <th class="py-3 px-2 text-gray-700">قیمت واحد</th>
                            <th class="py-3 px-2 text-gray-700">جمع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0;
                        foreach ($order['items'] as $item):
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                            ?>
                            <tr class="bg-[#EEEFE0] transition rounded">
                                <td class="py-2 px-2 align-middle">
                                    <img src="<?= $item['image_url'] ?>" alt=""
                                        class="w-14 h-20 object-cover rounded shadow border border-gray-200">
                                </td>
                                <td class="py-2 px-2 align-middle font-bold text-lg text-[#4B6043]">
                                    <?= htmlspecialchars($item['title']) ?>
                                </td>
                                <td class="py-2 px-2 align-middle text-gray-600"><?= htmlspecialchars($item['author']) ?></td>
                                <td class="py-2 px-2 align-middle text-base"><?= toPersianDigits($item['quantity']) ?></td>
                                <td class="py-2 px-2 align-middle text-base">
                                    <?= toPersianDigits(number_format($item['price'], 0, '.', ',')) ?> <span
                                        class="text-xs text-gray-500">تومان</span>
                                </td>
                                <td class="py-2 px-2 align-middle text-base font-bold">
                                    <?= toPersianDigits(number_format($subtotal, 0, '.', ',')) ?> <span
                                        class="text-xs text-gray-500">تومان</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-gray-200 font-extrabold bg-white">
                            <td colspan="5" class="py-3 px-2 text-left text-lg">مبلغ کل:</td>
                            <td class="py-3 px-2 text-lg text-amber-700">
                                <?= toPersianDigits(number_format($total, 0, '.', ',')) ?> <span
                                    class="text-xs text-gray-500">تومان</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="mt-8 text-center">
            <a href="orders.php"
                class="inline-block px-6 py-2 bg-[#4B6043] text-white rounded-lg shadow hover:bg-[#5F6F52] transition font-bold text-lg">بازگشت
                به تاریخچه سفارش‌ها</a>
        </div>
    <?php endif; ?>
</div>
<script src="assets/js/helper.js"></script>
<script>
    document.querySelectorAll('[data-date]').forEach(el => {
        const gDate = el.getAttribute('data-date');
        el.textContent = toPersianDate(gDate);
    });
</script>
<?php
renderPage(ob_get_clean(), $pageTitle);
?>