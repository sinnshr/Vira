<?php
include_once __DIR__ . '/../route.php';
include_once __DIR__ . '/../src/auth.php';
if (isLoggedIn()) {
    $cart_items = fetchCart($_SESSION['id']);
}
?>
<header class="text-white p-2 sticky top-0 min-h-[80px] md:min-h-0"
    style="background-color: #5F6F52; transition: padding 0.4s cubic-bezier(.4,2,.6,1); z-index: 1000;" id="header">
    <nav class="container mx-auto flex justify-center items-center gap-x-12 min-h-[80px]" style="position: relative;">
        <ul class="flex items-center m-0 p-0 h-full gap-10 md:gap-10">
            <li>
                <a href="<?php echo $routes['books']; ?>" title="کتاب‌ها">
                    <i class="fas fa-book fa-xl text-black"></i>
                </a>
            </li>
            <li class="relative">
                <a href="<?php echo $routes['cart']; ?>" title="سبد خرید" class="relative inline-block">
                    <i class="fas fa-shopping-cart fa-xl text-black"></i>
                    <?php if (isset($_SESSION['id']) && !empty($cart_items)): ?>
                        <span
                            class="absolute -top-4 -right-2 flex items-center justify-center w-6 h-6 text-xs font-bold leading-none text-white bg-red-600 rounded-full z-10">
                            <?php echo toPersianDigits(count($cart_items)); ?>
                        </span>
                    <?php endif; ?>
                </a>
            </li>
        </ul>
        <div id="header-curve"
            class="hidden md:flex justify-center items-center w-[320px] h-[100px] rounded-tl-[160px_80px] rounded-tr-[160px_80px] rounded-bl-[160px_160px]
        rounded-br-[160px_160px] bg-[#5F6F52] overflow-hidden relative z-20 mb-[-50px] transition-transform transition-opacity duration-400 ease-[cubic-bezier(.4,2,.6,1)] border-b-0">
        </div>
        <a id="logo-link" href="/index.php"
            class="hidden md:flex justify-center items-center absolute left-1/2 top-[10px] -translate-x-1/2 translate-y-0 z-30 transition-all duration-400 ease-[cubic-bezier(.4,2,.6,1)]"
            style="transition-property: top, transform;">
            <img src="/assets/img/logo.png" alt="ویرا" style="height: 80px; object-fit: contain;">
        </a>
        <ul class="flex items-center m-0 p-0 h-full gap-10 md:gap-10">
            <?php if (isLoggedIn()): ?>
                <li>
                    <a href="<?php echo $routes['profile']; ?>" title="پروفایل">
                        <i class="fas fa-user fa-xl text-black"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $routes['orders']; ?>" title="تاریخچه‌ی سفارشات">
                        <i class="fa-solid fa-clock-rotate-left fa-xl text-black"></i>
                    </a>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo $routes['login']; ?>" title="ورود">
                        <i class="fas fa-sign-in-alt fa-xl text-black"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $routes['about']; ?>" title="درباره ما">
                        <i class="fas fa-info-circle fa-xl text-black"></i>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<script>
    (function () {
        var curve = document.getElementById('header-curve');
        var logoLink = document.getElementById('logo-link');
        var header = document.getElementById('header');
        function isLargeOrMediumScreen() {
            return window.innerWidth >= 768;
        }
        function handleScroll() {
            if (!isLargeOrMediumScreen()) {
                curve.style.transform = '';
                curve.style.opacity = '';
                logoLink.style.top = '';
                logoLink.style.transform = '';
                header.style.paddingTop = '';
                header.style.paddingBottom = '';
                header.style.minHeight = '80px';
                return;
            }
            if (window.scrollY > 30) {
                curve.style.transform = 'translateY(-100%)';
                curve.style.opacity = '0';
                logoLink.style.top = '50%';
                logoLink.style.transform = 'translate(-50%, -50%)';
                header.style.paddingTop = '1rem';
                header.style.paddingBottom = '1rem';
                header.style.minHeight = '';
            } else {
                curve.style.transform = 'translateY(0)';
                curve.style.opacity = '1';
                logoLink.style.top = '10px';
                logoLink.style.transform = 'translateX(-50%) translateY(0)';
                header.style.paddingTop = '';
                header.style.paddingBottom = '';
                header.style.minHeight = '';
            }
        }
        window.addEventListener('scroll', handleScroll);
        window.addEventListener('resize', handleScroll);
        handleScroll();
    })();
</script>