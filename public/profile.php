<?php
session_start();
require_once '../src/config.php';
require_once '../src/db.php';
require_once '../src/auth.php';
require_once '../src/user.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$user = getUserById($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (updateUser($userId, $name, $email)) {
        $user = getUserById($userId);
        $message = "اطلاعات با موفقیت به روز شد.";
    } else {
        $message = "خطا در به روز رسانی اطلاعات.";
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/tailwind.css">
    <title>پروفایل کاربر</title>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen">
    <?php include '../templates/header.php'; ?>
    <?php include '../templates/navbar.php'; ?>

    <div class="container mx-auto mt-10 max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-blue-700 text-center">پروفایل کاربر</h1>
        <?php if (isset($message)): ?>
            <div class="bg-green-500 text-white p-2 rounded mb-4 text-center"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" class="bg-white p-8 rounded-lg shadow-lg">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">نام:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">ایمیل:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full font-bold transition">به روز رسانی</button>
        </form>
    </div>

    <?php include '../templates/footer.php'; ?>

</body>

</html>