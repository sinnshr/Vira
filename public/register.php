<?php
session_start();
include 'includes/db.php';

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
include 'includes/header.php';
?>

<h1 class="text-2xl font-bold mb-4">ثبت‌نام</h1>
<form method="POST" class="space-y-4">
    <div>
        <label for="username">نام کاربری</label>
        <input type="text" id="username" name="username" required class="border p-2 w-full">
    </div>
    <div>
        <label for="password">رمز عبور</label>
        <input type="password" id="password" name="password" required class="border p-2 w-full">
    </div>
    <div>
        <label for="email">ایمیل</label>
        <input type="email" id="email" name="email" required class="border p-2 w-full">
    </div>
    <div>
        <label for="full_name">نام کامل</label>
        <input type="text" id="full_name" name="full_name" class="border p-2 w-full">
    </div>
    <div>
        <label for="address">آدرس</label>
        <textarea id="address" name="address" class="border p-2 w-full"></textarea>
    </div>
    <div>
        <label for="phone_number">شماره تلفن</label>
        <input type="text" id="phone_number" name="phone_number" class="border p-2 w-full">
    </div>
    <button type="submit" class="bg-blue-600 text-white p-2">ثبت‌نام</button>
</form>

<?php include 'includes/footer.php'; ?>