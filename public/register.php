<?php
session_start();
require_once __DIR__ . '/../src/user.php';
include_once __DIR__ . '/../route.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'] ?? '';
    $email = trim($_POST['email']);
    $full_name = $_POST['full_name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';

    if (getUserByUsername($username)) {
        $error = "نام کاربری قبلا ثبت شده است.";
    }

    if (!$error && !preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
        $error = "ایمیل باید یک Gmail معتبر باشد.";
    }

    if (!$error && $password !== $password_repeat) {
        $error = "رمز عبور و تکرار آن یکسان نیستند.";
    }

    if (!$error) {
        if (createUser($username, $password, $email)) {
            $user = getUserByUsername($username);
            $_SESSION['id'] = $user['id'];
            header("Location: profile.php");
            exit;
        } else {
            $error = "خطا در ثبت‌نام.";
        }
    }
}
include_once __DIR__ . '/../includes/helper.php';
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>ویرا - ثبت‌نام</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/includes/helper.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
        <h1 class="text-3xl font-bold mb-4"><img src="/assets/img/icon.png" alt="ویرا"
                class="inline-block w-12 h-12 mr-2">ثبت‌نام</h1>
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="mb-2 block text-gray-700 font-medium">نام کاربری</label>
                <input type="text" id="username" name="username" required class="border p-2 w-full rounded"
                    value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            <div>
                <label for="email" class="mb-2 block text-gray-700 font-medium">ایمیل</label>
                <input type="email" id="email" name="email" required class="border p-2 w-full rounded"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
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
            <div>
                <label for="password_repeat" class="mb-2 block text-gray-700 font-medium">تکرار رمز عبور</label>
                <div class="flex justify-center items-center">
                    <input type="password" id="password_repeat" name="password_repeat" required
                        class="border-none p-2 w-full rounded-r focus:outline-none">
                    <div class="bg-white flex items-center px-3 rounded-l" style="height: 40px;">
                        <button type="button" class="focus:outline-none" onclick="seePassword('password_repeat', 'icon_repeat')">
                            <i class="fa-regular fa-eye text-[#5F6F52] text-lg" id="icon_repeat"
                                title="مشاهده تکرار رمز عبور"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="bg-amber-600 hover:bg-amber-700 text-white p-2 w-full rounded transition-colors duration-200">ثبت‌نام</button>
        </form>
        <p class="mt-4">حساب کاربری دارید؟ <a href="<?php echo $routes['login']; ?>"
                class="text-[#5F6F52] font-bold">وارد شوید.</a></p>
    </div>
</body>

</html>