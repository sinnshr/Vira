<?php
include 'includes/db.php';
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
include 'includes/header.php';
?>

<h1 class="text-2xl font-bold mb-4">کتاب‌ها</h1>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <?php while ($book = $result->fetch_assoc()): ?>
        <div class="border p-4">
            <img src="<?php echo $book['image_url']; ?>" alt="<?php echo $book['title']; ?>" class="w-full h-48 object-cover mb-2">
            <h2 class="text-xl font-bold"><?php echo $book['title']; ?></h2>
            <p>نویسنده: <?php echo $book['author']; ?></p>
            <p>قیمت: <?php echo number_format($book['price'], 0, '.', ','); ?> تومان</p>
            <a href="book_detail.php?id=<?php echo $book['book_id']; ?>" class="bg-blue-600 text-white p-2 mt-2 inline-block">مشاهده جزئیات</a>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>