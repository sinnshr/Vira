<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "ویرا - سبد خرید";
ob_start();

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $book_ids = array_keys($_SESSION['cart']);
    $ids = implode(',', $book_ids);
    $sql = "SELECT * FROM books WHERE book_id IN ($ids)";
    $result = $conn->query($sql);
    $cart_items = [];
    while ($row = $result->fetch_assoc()) {
        $cart_items[$row['book_id']] = $row;
    }
}
?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="text-center mb-2 mt-12">
        <h1 class="text-3xl md:text-4xl font-bold text-[#5F6F52] mb-3">سبد خرید</h1>
        <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
    </div>

    <?php if (isset($cart_items) && !empty($cart_items)): ?>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Cart Items -->
            <div class="divide-y divide-gray-200">
                <?php
                $total = 0;
                foreach ($cart_items as $book_id => $book):
                    $quantity = $_SESSION['cart'][$book_id];
                    $subtotal = $book['price'] * $quantity;
                    $total += $subtotal;
                ?>
                    <div class="p-6 flex flex-col md:flex-row items-center gap-6 group hover:bg-gray-50 transition-colors">
                        <!-- Book Image -->
                        <div class="w-24 h-32 overflow-hidden rounded-lg shadow">
                            <img 
                                src="<?php echo $book['image_url']; ?>" 
                                alt="<?php echo $book['title']; ?>" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                        
                        <!-- Book Details -->
                        <div class="flex-1 text-center md:text-right">
                            <h3 class="text-xl font-bold text-indigo-800"><?php echo $book['title']; ?></h3>
                            <p class="text-gray-600 mt-1">نویسنده: <?php echo $book['author']; ?></p>
                        </div>
                        
                        <!-- Quantity & Price -->
                        <div class="flex items-center gap-8">
                            <div class="flex items-center">
                                <span class="text-gray-700 ml-2">تعداد:</span>
                                <span class="bg-gray-100 px-3 py-1 rounded-lg font-bold"><?php echo $quantity; ?></span>
                            </div>
                            
                            <div>
                                <p class="text-gray-700">قیمت واحد:</p>
                                <p class="text-amber-600 font-bold"><?php echo number_format($book['price'], 0, '.', ','); ?> تومان</p>
                            </div>
                            
                            <div>
                                <p class="text-gray-700">مجموع:</p>
                                <p class="text-indigo-700 font-bold"><?php echo number_format($subtotal, 0, '.', ','); ?> تومان</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Cart Summary -->
            <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-t">
                <div class="flex justify-between items-center">
                    <div class="text-xl font-bold text-indigo-800">
                        مجموع کل سبد خرید:
                    </div>
                    <div class="text-2xl font-bold text-purple-800">
                        <?php echo number_format($total, 0, '.', ','); ?> تومان
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <a href="../checkout.php" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:from-indigo-700 hover:to-purple-800 transform hover:-translate-y-0.5">
                        تکمیل خرید →
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-[#A9B388] rounded-full flex items-center justify-center mb-6">
            <i class="fa-solid fa-cart-shopping fa-2x text-[#FEFAE0]"></i>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">سبد خرید شما خالی است</h3>
            <p class="text-gray-600 mb-6">می‌توانید با مراجعه به صفحه کتاب‌ها، کتاب‌های جدید را کشف کنید.</p>
            <a href="/public/books.php" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#A9B388] to-[#5F6F52] text-white rounded-lg font-medium hover:from-[#7C8B62] hover:to-[#43513C]">
                مشاهده کتاب‌ها
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
        </div>
    <?php endif; ?>
</div>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>