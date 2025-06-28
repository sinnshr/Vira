<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "ویرا - سبد خرید";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Handle quantity increase/decrease and removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_book_id'])) {
        deleteFromCart($_POST['remove_book_id']);
    } elseif (isset($_POST['change_quantity_book_id'], $_POST['change_quantity_action'])) {
        $book_id = $_POST['change_quantity_book_id'];
        $action = $_POST['change_quantity_action'];
        if ($action === 'increase') {
            changeCartQuantity($book_id, 1);
        } elseif ($action === 'decrease') {
            changeCartQuantity($book_id, -1);
        }
    }
}

ob_start();
$cart_items = fetchCart($_SESSION['id']);
?>

<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="text-center mb-2 mt-12">
        <h1 class="text-3xl md:text-4xl font-bold text-[#5F6F52] mb-3">سبد خرید</h1>
        <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
    </div>

    <?php if (isset($cart_items) && !empty($cart_items)): ?>
        <div class="bg-white rounded-2xl shadow-lg mt-12 relative">
            <div class="divide-y divide-gray-300">
                <?php
                $total = 0;
                foreach ($cart_items as $book_id => $book):
                    $quantity = $book['quantity'];
                    $subtotal = $book['price'] * $quantity;
                    $total += $subtotal;
                    ?>
                    <div class="p-6 flex flex-col md:flex-row items-center gap-6 group hover:bg-gray-50 transition-colors">
                        <div class="w-24 h-32 overflow-hidden rounded-lg shadow">
                            <img src="<?php echo $book['image_url']; ?>" alt="<?php echo $book['title']; ?>"
                                class="w-full h-full object-cover">
                        </div>

                        <div class="flex-1 text-center md:text-right">
                            <h3 class="text-xl font-bold text-[#4B5945]"><?php echo $book['title']; ?></h3>
                            <p class="text-gray-600 mt-1">نویسنده: <?php echo $book['author']; ?></p>
                        </div>

                        <div class="flex items-center gap-8">
                            <div class="flex items-center">
                                <span class="text-gray-700 ml-2">تعداد:</span>
                                <form method="post" class="flex items-center space-x-1 space-x-reverse">
                                    <input type="hidden" name="change_quantity_book_id" value="<?php echo $book_id; ?>">
                                    <button type="submit" name="change_quantity_action" value="increase"
                                        class="w-8 h-8 rounded-lg bg-[#A9B388] hover:bg-[#5F6F52] text-white flex items-center justify-center transition"
                                        title="افزایش تعداد">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <span
                                        class="bg-gray-100 px-3 py-1 rounded-lg font-bold mx-2 select-none min-w-[2.5rem] text-center">
                                        <?php echo toPersianDigits($quantity); ?>
                                    </span>
                                    <button type="submit" name="change_quantity_action" value="decrease"
                                        class="w-8 h-8 rounded-lg bg-[#A9B388] hover:bg-[#5F6F52] text-white flex items-center justify-center transition disabled:opacity-60 disabled:cursor-not-allowed"
                                        title="کاهش تعداد" <?php if ($quantity <= 1)
                                            echo 'disabled'; ?>>
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                </form>
                            </div>

                            <div>
                                <p class="text-gray-700">قیمت واحد:</p>
                                <p class="text-amber-600 font-bold">
                                    <?php echo toPersianDigits(number_format($book['price'], 0, '.', ',')); ?>
                                    تومان
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-700">مجموع:</p>
                                <p class="text-[#5F6F52] font-bold">
                                    <?php echo toPersianDigits(number_format($subtotal, 0, '.', ',')); ?> تومان
                                </p>
                            </div>
                        </div>
                        <form method="post" class="mt-4 md:mt-0">
                            <input type="hidden" name="remove_book_id" value="<?php echo $book_id; ?>">
                            <button type="submit"
                                class="text-red-600 hover:text-white font-bold px-4 py-2 rounded-lg border border-red-200 hover:bg-red-600 transition"
                                title="حذف از سبد">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="p-6 bg-[#D2D0A0] sticky bottom-0 left-0 w-full z-20 rounded-none md:rounded-b-2xl">
                <div class="flex flex-col md:flex-row items-center justify-center md:justify-between w-full">
                    <div class="flex items-center justify-center mb-4 md:mb-0">
                        <span class="text-sm font-medium text-gray-600">مجموع کل سبد خرید:&nbsp;&nbsp;</span>
                        <span class="text-2xl font-extrabold text-[#163020]">
                            <?php echo toPersianDigits(number_format($total, 0, '.', ',')); ?> تومان
                        </span>
                    </div>
                    <div class="flex justify-center">
                        <a href="/public/checkout.php"
                            class="px-8 py-3 bg-amber-500 hover:bg-amber-600 text-[#163020] font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                            <i class="fa-solid fa-check-to-slot text-[#163020] mx-2 fa-lg"></i>
                            تکمیل خرید
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-[#A9B388] rounded-full flex items-center justify-center mb-6">
                <i class="fa-solid fa-cart-shopping fa-2x text-[#FEFAE0]"></i>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">سبد خرید شما خالی است</h3>
            <p class="text-gray-600 mb-6">می‌توانید با مراجعه به صفحه کتاب‌ها، کتاب‌های جدید را کشف کنید.</p>
            <a href="/public/books.php"
                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#A9B388] to-[#5F6F52] text-white rounded-lg font-medium hover:from-[#7C8B62] hover:to-[#43513C]">
                مشاهده کتاب‌ها
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>