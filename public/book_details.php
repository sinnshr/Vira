<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$book_id = $_GET['id'];
$sql = "SELECT * FROM books WHERE book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();

$pageTitle = "ویرا - " . $book['title'];
ob_start();
?>

<div class="max-w-7xl mx-auto px-4 py-8 mt-10">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-2/5 p-6 bg-[#EAEBD0] flex items-center justify-center min-h-0">
                <div class="max-w-xs w-full shadow-2xl rounded-2xl overflow-hidden">
                    <img 
                        src="<?php echo $book['image_url']; ?>" 
                        alt="<?php echo $book['title']; ?>" 
                        class="w-full h-auto object-cover"
                    >
                </div>
            </div>
            
            <div class="lg:w-3/5 p-6">
                <h1 class="text-2xl font-bold text-indigo-800 mb-3"><?php echo $book['title']; ?></h1>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="bg-indigo-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="mr-4">
                            <p class="text-gray-600">نویسنده</p>
                            <p class="text-lg font-medium"><?php echo $book['author']; ?></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-indigo-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <div class="mr-4">
                            <p class="text-gray-600">ژانر</p>
                            <p class="text-lg font-medium"><?php echo $book['genre']; ?></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="bg-amber-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mr-4">
                            <p class="text-gray-600">قیمت</p>
                            <?php
                            
                            ?>
                            <p class="text-2xl font-bold text-amber-600">
                                <?php echo toPersianDigits(number_format($book['price'], 0, '.', ',')); ?> تومان
                            </p>
                        </div>
                    </div>
                    
                    <div class="pt-2">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">درباره کتاب</h3>
                        <p class="text-gray-700 leading-relaxed line-clamp-3"><?php echo $book['description']; ?></p>
                    </div>
                    
                    <form method="POST" action="" class="pt-4" onsubmit="addToCart(); return false;">
                        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                        <button 
                            type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:from-indigo-700 hover:to-purple-800 transform hover:-translate-y-0.5 flex items-center"
                        >
                            افزودن به سبد خرید
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>