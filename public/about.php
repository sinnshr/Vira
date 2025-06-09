<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$pageTitle = ' ویرا - درباره‌ی ما';
ob_start();
?>
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-8 mt-12 mb-12">
    <h1 class="text-3xl font-bold text-[#5F6F52] mb-4 text-center">درباره‌ی ویرا</h1>
    <p class="text-gray-700 text-lg leading-relaxed mb-6 text-justify">
        ویرا یک کتاب‌سرای آنلاین است که با هدف ترویج فرهنگ کتاب‌خوانی و دسترسی آسان به کتاب‌های متنوع برای فارسی‌زبانان راه‌اندازی شده است.
        ما تلاش می‌کنیم با ارائه تجربه کاربری ساده، محیطی امن و مجموعه‌ای غنی از کتاب‌ها، بستری مناسب برای علاقه‌مندان به مطالعه فراهم کنیم.
    </p>
    <div class="bg-[#EAEBD0] rounded-lg p-5 mb-6">
        <h2 class="text-xl font-bold text-[#5F6F52] mb-2">ماموریت ما</h2>
        <p class="text-gray-700 leading-relaxed text-justify font-medium">
            ماموریت ویرا فراهم‌کردن دسترسی سریع و آسان به کتاب‌های باکیفیت، حمایت از نویسندگان و ناشران ایرانی و ایجاد جامعه‌ای پویا از کتاب‌دوستان است.
            ما به نوآوری، صداقت و رضایت کاربران متعهد هستیم.
        </p>
    </div>
    <p class="text-gray-600 text-center mt-8 font-medium">
        از همراهی شما سپاسگزاریم.<br>
        تیم ویرا
    </p>
</div>
<?php
renderPage(ob_get_clean(), $pageTitle);

