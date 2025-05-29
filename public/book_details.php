<?php
include '../includes/db.php';
$book_id = $_GET['id'];
$sql = "SELECT * FROM books WHERE book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$book = $stmt->get_result()->fetch_assoc();
include '../includes/header.php';
?>

<h1 class="text-2xl font-bold mb-4"><?php echo $book['title']; ?></h1>
<div class="flex">
    <img src="<?php echo $book['image_url']; ?>" alt="<?php echo $book['title']; ?>" class="w-1/3 h-auto object-cover mr-4">
    <div>
        <p>نویسنده: <?php echo $book['author']; ?></p>
        <p>ژانر: <?php echo $book['genre']; ?></p>
        <p>قیمت: <?php echo number_format($book['price'], 0, '.', ','); ?> تومان</p>
        <p><?php echo $book['description']; ?></p>
        <form method="POST" action="../add_to_cart.php">
            <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
            <button type="submit" class="bg-green-600 text-white p-2 mt-4">افزودن به سبد خرید</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>