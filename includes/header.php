<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرا - هر صفحه یک جهان</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @font-face {
            font-family: 'Dana';
            src: url='/fonts/DANA-MEDIUM.TTF' format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        body {
            font-family: 'Dana', 'Tahoma', 'Arial', sans-serif;
        }
    </style>
</head>
<body>
    <header class="text-white p-2 sticky top-0" style="background-color: #5F6F52; transition: padding 0.4s cubic-bezier(.4,2,.6,1);" id="header">
        <nav class="container mx-auto flex justify-center items-center gap-x-12" style="position: relative;">
            <ul class="flex space-x-10 space-x-reverse items-center m-0 p-0">
                <li>
                    <a href="books.php" title="کتاب‌ها">
                        <i class="fas fa-book fa-xl text-black"></i>
                    </a>
                </li>
                <li>
                    <a href="cart.php" title="سبد خرید">
                        <i class="fas fa-shopping-cart fa-xl text-black"></i>
                    </a>
                </li>
            </ul>
            <div id="header-curve" class="flex justify-center items-center"
                 style="
                    width: 320px;
                    height: 100px;
                    border-top-left-radius: 160px 80px;
                    border-top-right-radius: 160px 80px;
                    border-bottom-left-radius: 160px 160px;
                    border-bottom-right-radius: 160px 160px;
                    background: #5F6F52;
                    overflow: hidden;
                    position: relative;
                    z-index: 20;
                    border-bottom: none;
                    margin-bottom: -50px;
                    transition: transform 0.4s cubic-bezier(.4,2,.6,1), opacity 0.3s;
                ">
                <!-- Curve background only -->
            </div>
            <a id="logo-link" href="index.php"
               style="display: flex; justify-content: center; align-items: center; position: absolute; left: 50%; top: 10px; transform: translateX(-50%) translateY(0); z-index: 30; transition: top 0.4s cubic-bezier(.4,2,.6,1), transform 0.4s cubic-bezier(.4,2,.6,1);">
                <img src="assets/img/logo.png" alt="ویرا" style="height: 80px; object-fit: contain;">
            </a>
            <ul class="flex space-x-10 space-x-reverse items-center m-0 p-0">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li>
                        <a href="profile.php" title="پروفایل">
                            <i class="fas fa-user fa-xl text-black"></i>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" title="خروج">
                            <i class="fas fa-sign-out-alt fa-xl text-black"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="public/login.php" title="ورود">
                            <i class="fas fa-sign-in-alt fa-xl text-black"></i>
                        </a>
                    </li>
                    <li>
                        <a href="about.php" title="درباره ما">
                            <i class="fas fa-info-circle fa-xl text-black"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <script>
    (function() {
        var curve = document.getElementById('header-curve');
        var logoLink = document.getElementById('logo-link');
        var header = document.getElementById('header');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 30) {
                curve.style.transform = 'translateY(-100%)';
                curve.style.opacity = '0';
                logoLink.style.top = '50%';
                logoLink.style.transform = 'translate(-50%, -50%)';
                header.style.paddingTop = '1rem';
                header.style.paddingBottom = '1rem';
            } else {
                curve.style.transform = 'translateY(0)';
                curve.style.opacity = '1';
                logoLink.style.top = '10px';
                logoLink.style.transform = 'translateX(-50%) translateY(0)';
                header.style.paddingTop = '';
                header.style.paddingBottom = '';
            }
        });
    })();
    </script>
