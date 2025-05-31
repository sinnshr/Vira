<?php
session_start();
require_once __DIR__ . '/../includes/bootstrap.php';

$userId = $_SESSION['id'];
$user = getUserById($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/@gmail\.com$/', $email)) {
        $message = "ایمیل باید یک Gmail معتبر باشد.";
    } else {
        if (updateUser($userId, $username, $email)) {
            $user = getUserById($userId);
            $message = "اطلاعات با موفقیت به روز شد.";
        } else {
            $message = "خطا در به روز رسانی اطلاعات.";
        }
    }
}

$pageTitle = "ویرا - پروفایل";
ob_start();
?>

<div class="max-w-lg mx-auto px-4 py-8">
    <div class="text-center mb-2 mt-12">
        <h1 class="text-3xl md:text-4xl font-bold text-[#5F6F52] mb-3">پروفایل</h1>
        <div class="w-24 h-1 bg-amber-500 mx-auto rounded-full"></div>
    </div>
    <?php if (isset($message)): ?>
        <div class="bg-green-500 text-white p-2 rounded mb-4 text-center"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="POST" class="bg-[#A9B388] p-8 m-4 rounded-lg shadow-lg">
        <div class="mb-4">
            <label for="username" class="block text-gray-700 font-semibold">نام کاربری:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold">ایمیل:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="mt-1 block w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <button type="submit" class="bg-[#DA8359] hover:bg-[#b96b44] text-white px-4 py-2 rounded w-full font-bold transition">به‌روزرسانی</button>
    </form>
</div>

<?php
renderPage(ob_get_clean(), $pageTitle);
?>