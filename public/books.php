<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = "ویرا - کتاب‌های ما";
ob_start();
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="text-center mb-12 mt-12">
        <h1 class="text-4xl md:text-5xl font-bold text-[#5F6F52] mb-3 animate-fade-in-down">کتاب‌های ما</h1>
        <div class="w-0 h-1 bg-amber-500 mx-auto rounded-full animate-grow-bar"></div>
        <p class="mt-4 text-gray-600 max-w-2xl mx-auto">هر کتاب دریچه‌ای به جهانی نو - گزیده‌ای از بهترین آثار ادبی</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php while ($book = $result->fetch_assoc()): ?>
            <div class="group bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                <div class="relative h-64 overflow-hidden">
                    <img 
                        src="<?php echo $book['image_url']; ?>" 
                        alt="<?php echo $book['title']; ?>" 
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                    >
                    <div class="absolute top-4 left-4 bg-amber-500 text-white px-3 py-1 rounded-full font-bold shadow-md">
                        <?php echo toPersianDigits(number_format($book['price'], 0, '.', ',')); ?> تومان
                    </div>
                </div>
                
                <div class="p-5">
                    <h2 class="text-xl font-bold mb-2 bg-clip-text text-[#5F6F52]">
                        <?php echo $book['title']; ?>
                    </h2>
                    
                    <div class="flex items-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <p class="text-gray-600"><?php echo $book['author']; ?></p>
                    </div>
                    
                    <a 
                        href="book_details.php?id=<?php echo $book['book_id']; ?>" 
                        class="mt-3 inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#BF9264] to-[#754E1A] text-white rounded-lg hover:from-[#B1AF7A] hover:to-[#8A6F3F] hover:shadow-lg"
                    >
                        مشاهده جزئیات
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
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
        from { width: 0; }
        to { width: 6rem; }
    }
    .animate-grow-bar {
        animation: grow-bar 0.7s cubic-bezier(0.4,0,0.2,1) forwards;
    }
</style>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>