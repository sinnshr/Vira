<?php
require_once '../src/auth.php';
require_once '../src/user.php';


$userId = $_SESSION['id'];
$user = getUserById($userId);

if (!$user || !empty($user['password'])) {
    header('Location: /profile.php');
    exit;
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (strlen($password) < 6) {
        $errors[] = "رمز عبور باید حداقل ۶ کاراکتر باشد.";
    } elseif ($password !== $confirm) {
        $errors[] = "رمز عبور و تکرار آن یکسان نیستند.";
    } else {
        if (updateUserPassword($userId, $password)) {
            $success = true;
        } else {
            $errors[] = "خطا در ثبت رمز عبور.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>ویرا - ایجاد رمز عبور</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/js/helper.js"></script>
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
            ایجاد رمز عبور
        </h2>
        <?php if ($success): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                رمز عبور با موفقیت ثبت شد.
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
        <form method="POST" class="space-y-5">
            <div>
                <label class="block mb-1 text-gray-700 font-medium" for="password">رمز عبور جدید</label>
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
                <label class="block mb-1 text-gray-700 font-medium" for="confirm_password">تکرار رمز عبور</label>
                <div class="flex justify-center items-center">
                    <input type="password" id="confirm_password" name="confirm_password" required
                        class="border-none p-2 w-full rounded-r focus:outline-none">
                    <div class="bg-white flex items-center px-3 rounded-l" style="height: 40px;">
                        <button type="button" class="focus:outline-none"
                            onclick="seePassword('confirm_password', 'icon_repeat')">
                            <i class="fa-regular fa-eye text-[#5F6F52] text-lg" id="icon_repeat"
                                title="مشاهده رمز عبور"></i>
                        </button>
                    </div>
                </div>
            </div>
            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 rounded  transition">ثبت
                رمز عبور</button>
        </form>
        <a href="profile.php" class="block text-center text-[#2C3930] mt-4 underline">بازگشت به پروفایل</a>
    </div>
</body>

</html>