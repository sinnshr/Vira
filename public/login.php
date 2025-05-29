<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: profile.php");
        } else {
            echo "رمز عبور اشتباه است.";
        }
    } else {
        echo "نام کاربری یافت نشد.";
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
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
        <h1 class="text-3xl font-bold mb-4">ورود</h1>
        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="mb-2 block">نام کاربری</label>
                <input type="text" id="username" name="username" required class="border p-2 w-full rounded">
            </div>
            <div>
                <label for="password" class="mb-2 block">رمز عبور</label>
                <input type="password" id="password" name="password" required class="border p-2 w-full rounded">
            </div>
            <button type="submit" class="bg-[#DA8359] text-white p-2 w-full rounded transition-colors duration-200 hover:bg-[#b96b44]">ورود</button>
        </form>
        <p class="mt-4">حساب کاربری ندارید؟ <a href="register.php" class="text-[#5F6F52] font-bold">ثبت‌نام کنید.</a></p>
    </div>
</body>
</html>