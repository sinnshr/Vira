<?php
require_once '../src/auth.php';

$errors = [];
$success = false;

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $repeat_password = $_POST['repeat_password'] ?? '';

    if (empty($current_password) || empty($new_password) || empty($repeat_password)) {
        $errors[] = 'لطفاً همه فیلدها را پر کنید.';
    } else {
        $userId = $_SESSION['id'];
        $hashedPassword = getUserPassword($userId);

        if (!$hashedPassword || !password_verify($current_password, $hashedPassword)) {
            $errors[] = 'رمز عبور فعلی اشتباه است.';
        } elseif ($current_password === $new_password) {
            $errors[] = 'رمز عبور جدید باید متفاوت از رمز عبور فعلی باشد.';
        } elseif ($new_password !== $repeat_password) {
            $errors[] = 'رمز عبور جدید و تکرار آن یکسان نیستند.';
        } elseif (strlen($new_password) < 6) {
            $errors[] = 'رمز عبور جدید باید حداقل ۶ کاراکتر باشد.';
        } else {
            $newHashed = password_hash($new_password, PASSWORD_DEFAULT);
            if (updateUserPassword($userId, $newHashed)) {
                $success = true;
            } else {
                $errors[] = 'خطا در بروزرسانی رمز عبور.';
            }
        }
    }
}
include_once __DIR__ . '/../includes/helper.php';
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>ویرا - تغییر رمز عبور</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <div class="bg-[#A9B388] shadow-md rounded-lg p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold mb-4">
            <img src="/assets/img/icon.png" alt="ویرا" class="inline-block w-12 h-12 mr-2">
            تغییر رمز عبور
        </h2>
        <?php if ($success): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">رمز عبور با موفقیت تغییر کرد.
                <a href="profile.php" class="font-bold underline">بازگشت به پروفایل</a>
            </div>
        <?php endif; ?>
        <?php if ($errors): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <?php foreach ($errors as $error): ?>
                    <div><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" class="space-y-5">
            <div>
                <label class="block mb-1 text-gray-700 font-medium" for="current_password">رمز عبور فعلی</label>
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
                <label class="block mb-1 text-gray-700 font-medium" for="new_password">رمز عبور جدید</label>
                <div class="flex justify-center items-center">
                    <input type="password" id="new_password" name="new_password" required
                        class="border-none p-2 w-full rounded-r focus:outline-none">
                    <div class="bg-white flex items-center px-3 rounded-l" style="height: 40px;">
                        <button type="button" class="focus:outline-none" onclick="seePassword('new_password', 'icon_new')">
                            <i class="fa-regular fa-eye text-[#5F6F52] text-lg" id="icon_new" title="مشاهده رمز عبور"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <label class="block mb-1 text-gray-700 font-medium" for="repeat_password">تکرار رمز عبور جدید</label>
                <div class="flex justify-center items-center">
                    <input type="password" id="repeat_password" name="repeat_password" required
                        class="border-none p-2 w-full rounded-r focus:outline-none">
                    <div class="bg-white flex items-center px-3 rounded-l" style="height: 40px;">
                        <button type="button" class="focus:outline-none"
                            onclick="seePassword('repeat_password', 'icon_repeat')">
                            <i class="fa-regular fa-eye text-[#5F6F52] text-lg" id="icon_repeat"
                                title="مشاهده رمز عبور"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 rounded  transition">تغییر
                رمز عبور</button>
        </form>
    </div>
</body>

</html>