<?php
require_once __DIR__ . '/../src/auth.php';
include_once __DIR__ . '/../route.php';
require __DIR__ . '/../vendor/autoload.php';

$rootPath = realpath(__DIR__ . '/../');
$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->safeLoad();

$client = new Google\Client;

$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_CLIENT_REDIRECT_URI']);

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)) {
        header("Location: books.php");
        exit;
    } else {
        $error = "نام کاربری یا رمز عبور اشتباه است.";
    }
}
include_once __DIR__ . '/../includes/helper.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>ویرا - ورود به سامانه</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="/includes/helper.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @font-face {
            font-family: 'Dana';
            src: url('../fonts/DANA-MEDIUM.TTF') format('TTF');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        body {
            font-family: 'Dana', 'Tahoma', 'Arial', sans-serif;
        }
    </style>
</head>

<body class="bg-[#FEFAE0] flex items-center justify-center min-h-screen">
    <div class="bg-[#A9B388] p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-3xl font-bold mb-4">
            <img src="/assets/img/icon.png" alt="ویرا" class="inline-block w-12 h-12 mr-2">
            ورود
        </h1>

        <!-- error section -->
        <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 rounded bg-red-100 border border-red-400 text-red-700 text-center" id="error-popup">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="mb-2 block text-gray-700 font-medium">نام کاربری</label>
                <input type="text" id="username" name="username" required
                    class="border p-2 w-full rounded focus:outline-none">
            </div>
            <div>
                <label for="password" class="mb-2 block text-gray-700 font-medium">رمز عبور</label>
                <div class="flex justify-center items-center">
                    <input type="password" id="password" name="password" required
                        class="border-none p-2 w-full rounded-r focus:outline-none">
                    <div class="bg-white flex items-center px-3 rounded-l" style="height: 40px;">
                        <button type="button" class="focus:outline-none" onclick="seePassword('password', 'icon')">
                            <i class="fa-regular fa-eye text-[#5F6F52] text-lg" id="icon" title="مشاهده رمز عبور"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="bg-amber-600 hover:bg-amber-700 text-white p-2 w-full rounded transition-colors duration-200 font-bold">ورود
            </button>
        </form>
        <a href="<?= $url ?>"
            class="mt-4 w-full flex items-center justify-center bg-[#FEFAE0] border border-[#5F6F52] text-[#5F6F52] font-bold py-2 rounded transition-colors duration-200 hover:bg-[#5F6F52] hover:text-white">
            <img width="25" height="25" src="https://img.icons8.com/3d-fluency/94/google-logo.png" alt="google-logo"
                class="ml-1" />
            ورود با حساب گوگل
        </a>
        <p class="mt-4">حساب کاربری ندارید؟ <a href="<?php echo $routes['register']; ?>"
                class="text-[#5F6F52] font-bold">ثبت‌نام کنید.</a></p>
    </div>
</body>

</html>