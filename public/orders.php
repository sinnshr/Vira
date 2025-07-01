<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "ویرا - تاریخچه سفارش‌ها";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id'];
$orders = getUserOrders($user_id);

ob_start();
?>
<div class="min-h-screen pt-10 pb-40">
    <div class="w-full max-w-3xl mx-auto flex flex-col items-center px-2 sm:px-4">
        <div class="text-center mt-6 mb-5 w-full">
            <h1 class="text-4xl font-bold text-[#283925] mb-3 mt-4 tracking-tight leading-none">تاریخچه سفارشات</h1>
            <div class="mx-auto h-1 w-28 bg-yellow-400 rounded mt-1"></div>
        </div>
        <?php if (empty($orders)): ?>
            <div class="w-full text-center my-14">
                <div class="inline-block bg-white px-8 py-8 rounded-lg shadow text-slate-400 text-lg">
                    شما تاکنون سفارشی ثبت نکرده‌اید.
                </div>
            </div>
        <?php else: ?>
            <div class="w-full max-w-2xl space-y-8 mt-10">
                <?php foreach ($orders as $order): ?>
                    <div
                        class="bg-white rounded-xl shadow-md p-7 flex flex-col md:flex-row md:items-center gap-3 md:gap-6 border border-transparent md:hover:border-green-200 transitional ease-in">
                        <div class="w-full md:flex-1 grid grid-cols-1 md:grid-cols-4 gap-3 place-items-start items-center">
                            <div>
                                <div class="font-bold text-xl tracking-tight text-amber-800">#<?= $order['id'] ?></div>
                                <div class="font-medium text-gray-400 text-[12.75px] mt-1">شماره سفارش</div>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800">
                                    <?= toPersianDigits(date('Y/m/d', strtotime($order['created_at']))) ?></div>
                                <div class="font-normal text-[12.75px] text-muted-400 text-zinc-400">تاریخ سفارش</div>
                            </div>
                            <div>
                                <div class="inline-block status-badge bg-orange-50 text-yellow-600 font-bold px-3.5 py-1.5 rounded hover:brightness-105 duration-100"
                                    title="<?= htmlspecialchars($order['status']) ?>"><?= htmlspecialchars($order['status']) ?>
                                </div>
                            </div>
                            <div>
                                <a href="order_details.php?id=<?= $order['id'] ?>" class="inline-block rounded-lg px-5 py-1.5 font-border font-medium text-sm text-white bg-[#4d6847] hover:bg-[#39693969]
                        duration-200 shadow hover:shadow-differentiev">جزئیات...</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="w-full text-center mt-16">
            <a href="index.php" class="inline-block cutUrl px-6 py-2 rounded-lg font-bold text-white bg-[#5F6F52]
         transition hover:bg-[#47623e] shadow-md tracking-tight">صفحه اصلی</a>
        </div>
    </div>
</div>
<?php
renderPage(ob_get_clean(), $pageTitle);
?>