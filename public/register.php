<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];

    $sql = "INSERT INTO users (username, password, email, full_name, address, phone_number) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $password, $email, $full_name, $address, $phone_number);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        header("Location: profile.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @font-face {
            font-family: 'Dana';
            src: url('/fonts/DANA-MEDIUM.TTF') format('TTF');
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
        <h1 class="text-3xl font-bold mb-4">ثبت‌نام</h1>
        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="mb-2 block">نام کاربری</label>
                <input type="text" id="username" name="username" required class="border p-2 w-full rounded">
            </div>
            <div>
                <label for="email" class="mb-2 block">ایمیل</label>
                <input type="email" id="email" name="email" required class="border p-2 w-full rounded">
            </div>
            <div>
                <label for="password" class="mb-2 block">رمز عبور</label>
                <input type="password" id="password" name="password" required class="border p-2 w-full rounded">
            </div>
            <div>
                <label for="password_repeat" class="mb-2 block">تکرار رمز عبور</label>
                <input type="password" id="password_repeat" name="password_repeat" required class="border p-2 w-full rounded">
            </div>

            <button type="submit" class="bg-[#DA8359] text-white p-2 w-full rounded transition-colors duration-200 hover:bg-[#b96b44]">ثبت‌نام</button>
        </form>
        <p class="mt-4">حساب کاربری دارید؟ <a href="login.php" class="text-[#5F6F52] font-bold">وارد شوید.</a></p>
    </div>
</body>
</html>

