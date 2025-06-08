<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "ویرا - کتاب‌های ما";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $result = addToCart($_POST['book_id']);
    if ($result === true) {
        $_SESSION['cart_message'] = ['type' => 'success', 'text' => 'کتاب با موفقیت به سبد خرید افزوده شد.'];
    } else {
        $_SESSION['cart_message'] = ['type' => 'error', 'text' => 'خطا در افزودن کتاب به سبد خرید.'];
    }
    header("Location: books.php");
    exit;
}
ob_start();

$book = new Book();
$books = $book->getAllBooks();
?>

<!-- ERROR/SUCCESS MESSAGE -->
<?php if (!empty($_SESSION['cart_message'])): ?>
    <div id="cart-popup-overlay" class="fixed inset-0 bg-black bg-opacity-40 z-50 flex items-center justify-center"></div>
    <div id="cart-popup-message" class="fixed left-1/2 top-1/2 z-50 px-8 py-6 rounded-2xl shadow-2xl text-white text-lg
        <?php echo $_SESSION['cart_message']['type'] === 'success' ? 'bg-lime-800' : 'bg-red-600'; ?>"
        style="min-width:260px; max-width:90vw; transform: translate(-50%, -50%);">
        <button id="cart-popup-close" type="button"
            class="absolute top-2 left-2 bg-transparent border-none text-white text-2xl cursor-pointer z-10 pl-2"
            aria-label="بستن">&times;</button>
        <?php echo $_SESSION['cart_message']['text']; ?>
    </div>
    <script>
        document.body.style.overflow = 'hidden';
        function closeCartPopup() {
            var popup = document.getElementById('cart-popup-message');
            var overlay = document.getElementById('cart-popup-overlay');
            if (popup) {
                popup.style.transition = 'opacity 0.5s';
                popup.style.opacity = '0';
            }
            if (overlay) {
                overlay.style.transition = 'opacity 0.5s';
                overlay.style.opacity = '0';
            }
            setTimeout(function () {
                if (popup) popup.remove();
                if (overlay) overlay.remove();
                document.body.style.overflow = '';
            }, 600);
        }
        setTimeout(closeCartPopup, 2500);
        document.getElementById('cart-popup-close').onclick = closeCartPopup;
    </script>
    <?php unset($_SESSION['cart_message']); ?>
<?php endif; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="text-center mb-12 mt-12">
        <h1 class="text-4xl md:text-5xl font-bold text-[#5F6F52] mb-3 animate-fade-in-down">کتاب‌های ما</h1>
        <div class="w-0 h-1 bg-amber-500 mx-auto rounded-full animate-grow-bar"></div>
        <p class="mt-4 text-gray-600 max-w-2xl mx-auto text-xl">هر کتاب دریچه‌ای به جهانی نو - گزیده‌ای از بهترین آثار
            ادبی</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php foreach ($books as $book): ?>
            <div
                class="group bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                <div class="relative h-64 overflow-hidden">
                    <img src="<?php echo $book['image_url']; ?>" alt="<?php echo $book['title']; ?>"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute top-4 left-4 bg-amber-500 text-white px-3 py-1 rounded-full font-bold shadow-md">
                        <?php echo toPersianDigits(number_format($book['price'], 0, '.', ',')); ?> تومان
                    </div>
                </div>

                <div class="p-5">
                    <h2 class="text-xl font-bold mb-2 bg-clip-text text-[#5F6F52]">
                        <?php echo $book['title']; ?>
                    </h2>

                    <div class="flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 ml-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <p class="text-gray-600"><?php echo $book['author']; ?></p>
                    </div>

                    <div class="flex items-center justify-between gap-2">
                        <a href="book_details.php?id=<?php echo $book['book_id']; ?>" class="mt-3 inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#BF9264] to-[#754E1A] text-white rounded-lg hover:from-[#B1AF7A] hover:to-[#8A6F3F] hover:shadow-lg
                            transition-all transform hover:-translate-y-2">
                            مشاهده جزئیات
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <?php if (isLoggedIn()): ?>
                            <form method="POST" action="">
                                <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                                <button class="mt-3 w-10 h-10 flex items-center justify-center bg-[#5F6F52] hover:bg-[#BF9264] text-white rounded-lg
                                transition-all transform hover:-translate-y-2" title="افزودن به سبد خرید">
                                    <i class="fa-solid fa-cart-plus fa-lg h-1 w-6"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    @keyframes fade-in-down {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.8s ease-out forwards;
    }

    @keyframes grow-bar {
        from {
            width: 0;
        }

        to {
            width: 6rem;
        }
    }

    .animate-grow-bar {
        animation: grow-bar 0.7s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
</style>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>