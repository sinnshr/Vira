<?php
session_start();
include 'includes/db.php';

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
include 'includes/header.php';
?>

<h1 class="text-2xl font-bold mb-4">ورود</h1>
<form method="POST" class="space-y-4">
    <div>
        <label for="username">نام کاربری</label>
        <input type="text" id="username" name="username" required class="border p-2 w-full">
    </div>
    <div>
        <label for="password">رمز عبور</label>
        <input type="password" id="password" name="password" required class="border p-2 w-full">
    </div>
    <button type="submit" class="bg-blue-600 text-white p-2">ورود</button>
</form>

<?php include 'includes/footer.php'; ?>