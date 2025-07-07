<?php
$pageTitle = "ویرا - هر صفحه یک جهان";
include_once __DIR__ . '/../route.php';
require_once __DIR__ . '/../includes/bootstrap.php';

$commentSuccess = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['comment'])) {
    require_once __DIR__ . '/src/comment.php';
    $commentSuccess = addComment();
}

ob_start();
?>
<style>
    @keyframes fade {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate {
        opacity: 0;
        transition: opacity 0.3s;
    }

    .animate.active {
        animation: fade 1s ease-out both;
        opacity: 1;
    }
</style>

<section class="w-full min-h-screen flex flex-col items-center justify-center py-6 px-4"
    style="background-color: #FEFAE0;">
    <h1 class="md:text-4xl lg:text-6xl font-bold text-[#5F6F52] mb-4 pt-4 text-center">ویرا - هر صفحه، یک جهان</h1>
    <p class="text-base md:text-lg mb-6 text-center max-w-3xl text-[#5F6F52]">
        ویرا کتاب‌فروشی آنلاین شماست. دنیایی از کتاب‌های متنوع، با ارسال سریع و پشتیبانی بیست‌وچهار ساعته. همین حالا
        کتاب مورد علاقه‌تان را جستجو و خرید کنید!
    </p>
    <button onclick="window.location.href='<?php echo $routes['books']; ?>'"
        class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-lg shadow transition">
        جستجوی کتاب‌ها
    </button>
    <div id="lottie-animation" style="width:250px; height:200px; z-index: 30;" class="flex justify-center my-0 py-0">
    </div>
</section>

<div style="width:100%; margin-top:-40px; line-height:0; background-color: #FEFAE0">
    <svg viewBox="0 0 1440 100" width="100%" height="100" preserveAspectRatio="none" style="display:block;">
        <path d="M0,80 C480,120 960,0 1440,80 L1440,100 L0,100 Z" fill="#A9B388" />
    </svg>
</div>

<section class="w-full py-12 px-8 grid grid-cols-1 md:grid-cols-3 gap-10 bg-[#A9B388]">
    <div class="bg-white rounded-lg shadow p-7 flex flex-col items-center animate" style="animation-delay: 0.1s;">
        <i class="fas fa-book fa-3x text-[#B99470] mb-4"></i>
        <h2 class="text-xl font-bold mb-2">تنوع بی‌نظیر کتاب‌ها</h2>
        <p class="text-gray-700 text-center">دسترسی به صدها عنوان کتاب در موضوعات مختلف برای همه سلیقه‌ها.</p>
    </div>
    <div class="bg-white rounded-lg shadow p-7 flex flex-col items-center animate" style="animation-delay: 0.3s;">
        <i class="fas fa-truck fa-3x text-[#B99470] mb-4"></i>
        <h2 class="text-xl font-bold mb-2">ارسال سریع</h2>
        <p class="text-gray-700 text-center">تحویل سریع و مطمئن کتاب‌ها به سراسر کشور.</p>
    </div>
    <div class="bg-white rounded-lg shadow p-7 flex flex-col items-center animate" style="animation-delay: 0.5s;">
        <i class="fas fa-headset fa-3x text-[#B99470] mb-4"></i>
        <h2 class="text-xl font-bold mb-2">پشتیبانی ۲۴ ساعته</h2>
        <p class="text-gray-700 text-center">تیم پشتیبانی ما همیشه آماده پاسخگویی به سوالات شماست.</p>
    </div>
</section>

<div style="width:100%; margin-top:-40px; line-height:0; background-color: #A9B388">
    <svg viewBox="0 0 1440 100" width="100%" height="100" preserveAspectRatio="none" style="display:block;">
        <path d="M0,80 C480,120 960,0 1440,80 L1440,100 L0,100 Z" fill="#FEFAE0" />
    </svg>
</div>

<section class="w-full py-10 px-2 sm:px-4 bg-[#FEFAE0] flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
    <div class="flex-1 w-full">
        <h2 class="text-xl sm:text-2xl font-bold mb-4 text-[#5F6F52] mx-1 px-2 sm:px-8 md:px-12">با ارسال نظر، به پیشرفت ما کمک کنید.</h2>
        <form method="post" action="" class="w-full max-w-xl bg-[#A9B388] rounded-lg shadow p-4 sm:p-6 mb-6 mx-auto">
            <div class="mb-4">
                <label class="block text-[#FEFAE0] mb-2" for="name">نام شما:</label>
                <input type="text" id="name" name="name" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#B99470] text-sm sm:text-base">
            </div>
            <div class="mb-4">
                <label class="block text-[#FEFAE0] mb-2" for="comment">نظر شما:</label>
                <textarea id="comment" name="comment" rows="3" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#B99470] text-sm sm:text-base"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded transition text-sm sm:text-base">
                    ارسال نظر
                </button>
            </div>
            <?php if (isset($commentSuccess)): ?>
                <div id="comment-popup" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
                    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center relative">
                        <button onclick="document.getElementById('comment-popup').style.display='none';"
                            class="absolute top-2 right-3 text-gray-400 hover:text-gray-700 text-2xl font-bold">&times;</button>
                        <?php if ($commentSuccess === true): ?>
                            <p class="text-green-600 mt-2">نظر شما با موفقیت ثبت شد.</p>
                        <?php else: ?>
                            <p class="text-red-600 mt-2">ثبت نظر با خطا مواجه شد.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <div class="flex justify-center items-center w-full md:w-auto mt-4 md:mt-0">
        <img src="/assets/img/comment.png" alt="comment" class="max-w-xs sm:max-w-md md:max-w-lg w-full h-auto" style="max-width:600px;">
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js"></script>
<script>
    lottie.loadAnimation({
        container: document.getElementById('lottie-animation'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '/assets/img/animation.json'
    });
    document.addEventListener('DOMContentLoaded', function () {
        const animatedElements = document.querySelectorAll('.animate');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.2 });

        animatedElements.forEach(el => observer.observe(el));
    });
    setTimeout(function () {
        var popup = document.getElementById('comment-popup');
        if (popup) popup.style.display = 'none';
    }, 2000);
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../includes/layout.php';
?>