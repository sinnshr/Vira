<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$book_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $result = addToCart($_POST['book_id']);
    if ($result === true) {
        $_SESSION['cart_message'] = ['type' => 'success', 'text' => 'کتاب با موفقیت به سبد خرید افزوده شد.'];
    } else {
        $_SESSION['cart_message'] = ['type' => 'error', 'text' => 'خطا در افزودن کتاب به سبد خرید.'];
    }
    header("Location: book_details.php?id=" . urlencode($_POST['book_id']));
    exit;
}

$bookObj = new Book();
$book = $bookObj->getBookById($book_id);

$pageTitle = "ویرا - " . $book['title'];
ob_start();
?>

<!-- ERROR/SUCCESS MESSAGE -->
<?php if (!empty($_SESSION['cart_message'])): ?>
    <div id="cart-popup-message" class="fixed top-8 left-1/2 transform -translate-x-1/2 z-50 px-6 py-4 rounded-xl shadow-lg text-white text-lg
        <?php echo $_SESSION['cart_message']['type'] === 'success' ? 'bg-green-600' : 'bg-red-600'; ?>"
        style="min-width:220px;">
        <?php echo $_SESSION['cart_message']['text']; ?>
    </div>
    <script>

    </script>
    <?php unset($_SESSION['cart_message']); ?>
<?php endif; ?>

<div class="max-w-5xl mx-auto px-2 py-10 my-10">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-2/5 p-4 bg-[#EAEBD0] flex items-center justify-center min-h-0">
                <div class="max-w-xs w-full shadow-2xl rounded-2xl overflow-hidden">
                    <img src="<?php echo $book['image_url']; ?>" alt="<?php echo $book['title']; ?>"
                        class="w-full h-auto object-cover">
                </div>
            </div>

            <div class="lg:w-3/5 p-4 flex flex-col h-full px-7">
                <h1 class="text-4xl font-bold text-[#5F6F52] my-3"><?php echo $book['title']; ?></h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-5">
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="bg-[#DDEB9D] p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5F6F52]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="mr-4">
                                <p class="text-gray-600">نویسنده</p>
                                <p class="text-lg font-medium"><?php echo $book['author']; ?></p>
                            </div>
                        </div>
                        <div class="flex items-start pt-5">
                            <div class="bg-amber-100 rounded-lg flex items-center justify-center"
                                style="width: 39px; height: 39px;">
                                <i class="fa-solid fa-tag fa-lg text-amber-700"></i>
                            </div>
                            <div class="mr-4 flex flex-col justify-center">
                                <p class="text-gray-600">قیمت</p>
                                <p class="text-2xl font-bold text-amber-600">
                                    <?php echo toPersianDigits(number_format($book['price'], 0, '.', ',')); ?> تومان
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="bg-[#DDEB9D] p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5F6F52]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                            </div>
                            <div class="mr-4">
                                <p class="text-gray-600">ژانر</p>
                                <p class="text-lg font-medium"><?php echo $book['genre']; ?></p>
                            </div>
                        </div>
                        <div class="flex items-start pt-5">
                            <div class="bg-amber-100 rounded-lg flex items-center justify-center"
                                style="width: 39px; height: 39px;">
                                <i class="fa-solid fa-info text-amber-700"></i>
                            </div>
                            <div class="mr-4 flex flex-col justify-center">
                                <h3 class="text-gray-600">درباره کتاب</h3>
                                <p class="text-lg font-medium"><?php echo $book['description']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 mt-auto mb-5">
                    <form method="POST" action="" class="w-full">
                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                        <button type="submit" class="px-6 py-3 mt-10 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl
                                             transition-all transform hover:-translate-y-2
                                             flex items-center float-end">
                            <i class="fa-solid fa-cart-plus fa-lg pe-2"></i>
                            افزودن به سبد خرید
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function () {
        var popup = document.getElementById('cart-popup-message');
        if (popup) {
            popup.style.transition = 'opacity 0.5s';
            popup.style.opacity = '0';
            setTimeout(function () {
                popup.remove();
            }, 600);
        }
    }, 2500);
</script>
<?php
renderPage(ob_get_clean(), $pageTitle);
?>