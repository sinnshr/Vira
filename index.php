<?php
$pageTitle = "ویرا - هر صفحه یک جهان";
ob_start();
?>
<style>
    body{
        margin: 0;
        padding: 0;
    }
    .curve {
        --mask:
            radial-gradient(245.97px at 50% calc(100% - 330px),#000 99%,#0000 101%) calc(50% - 220px) 0/440px 100%,
            radial-gradient(245.97px at 50% calc(100% + 220px),#0000 99%,#000 101%) 50% calc(100% - 110px)/440px 100% repeat-x;
        -webkit-mask: var(--mask);
                mask: var(--mask);
    }
</style>

<section class=" w-100 m-0 flex flex-col items-center justify-center py-12 px-4" style="background-color: #FEFAE0; min-height: 40vh;">
    <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold text-[#5F6F52] mb-4 pt-12 text-center">ویرا - هر صفحه، یک جهان</h1>
    <p class="text-base md:text-lg mb-6 text-center max-w-2xl text-[#5F6F52]">
        ویرا کتاب‌فروشی آنلاین شماست. دنیایی از کتاب‌های متنوع، با ارسال سریع و پشتیبانی بیست‌وچهار ساعته. همین حالا کتاب مورد علاقه‌تان را جستجو و خرید کنید!
    </p>
    <button onclick="window.location.href='books.php'" class="inline-block bg-[#B99470] hover:bg-[#A9743C] text-white font-bold py-3 px-8 rounded-lg shadow transition">
        جستجوی کتاب‌ها
    </button>
</section>

<div class="curve"></div>


<section class="container mx-auto mb-12 mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
    <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
        <i class="fas fa-book-open fa-3x text-green-700 mb-4"></i>
        <h2 class="text-xl font-bold mb-2">تنوع بی‌نظیر کتاب‌ها</h2>
        <p class="text-gray-700 text-center">دسترسی به صدها عنوان کتاب در موضوعات مختلف برای همه سلیقه‌ها.</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
        <i class="fas fa-truck fa-3x text-green-700 mb-4"></i>
        <h2 class="text-xl font-bold mb-2">ارسال سریع</h2>
        <p class="text-gray-700 text-center">تحویل سریع و مطمئن کتاب‌ها به سراسر کشور.</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
        <i class="fas fa-headset fa-3x text-green-700 mb-4"></i>
        <h2 class="text-xl font-bold mb-2">پشتیبانی ۲۴ ساعته</h2>
        <p class="text-gray-700 text-center">تیم پشتیبانی ما همیشه آماده پاسخگویی به سوالات شماست.</p>
    </div>
</section>

<?php
$content = ob_get_clean();
include 'includes/layout.php';
?>
