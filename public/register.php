<?php
session_start();
include '../includes/db.php';
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

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $error = "نام کاربری قبلا ثبت شده است.";
    }
    $stmt->close();

    if (!$error && !preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
        $error = "ایمیل باید یک Gmail معتبر باشد.";
    }

    if (!$error && $password !== $password_repeat) {
        $error = "رمز عبور و تکرار آن یکسان نیستند.";
    }

    if (!$error) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password_hashed, $email);

        if ($stmt->execute()) {
            $_SESSION['id'] = $stmt->insert_id;
            header("Location: profile.php");
            exit;
        } else {
            $error = "خطا در ثبت‌نام: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرا - ثبت‌نام</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h1 class="text-3xl font-bold mb-4"><img src="/assets/img/icon.png" alt="ویرا" class="inline-block w-12 h-12 mr-2">ثبت‌نام</h1>
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label for="username" class="mb-2 block">نام کاربری</label>
                <input type="text" id="username" name="username" required class="border p-2 w-full rounded" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            <div>
                <label for="email" class="mb-2 block">ایمیل</label>
                <input type="email" id="email" name="email" required class="border p-2 w-full rounded" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
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
        <p class="mt-4">حساب کاربری دارید؟ <a href="<?php echo $routes['login']; ?>" class="text-[#5F6F52] font-bold">وارد شوید.</a></p>
    </div>
</body>
</html>

