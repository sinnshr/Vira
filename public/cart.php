<?php
session_start();
include 'includes/db.php';

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $book_ids = array_keys($_SESSION['cart']);
    $ids = implode(',', $book_ids);
    $sql = "SELECT * FROM books WHERE book_id IN ($ids)";
    $result = $conn->query($sql);
    $cart_items = [];
    while ($row = $result->fetch_assoc()) {
        $cart_items[$row['book_id']] = $row;
    }
}
include 'includes/header.php';
?>

<h1 class="text-2xl font-bold mb-4">سبد خرید</h1>
<?php if (isset($cart_items) && !empty($cart_items)): ?>
    <table class="w-full border-collapse">
        <thead>
            <tr>
                <th class="border p-2">کتاب</th>
                <th class="border p-2">تعداد</th>
                <th class="border p-2">قیمت واحد</th>
                <th class="border p-2">قیمت کل</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($cart_items as $book_id => $book):
                $quantity = $_SESSION['cart'][$book_id];
                $subtotal = $book['price'] * $quantity;
                $total += $subtotal;
            ?>
                <tr>
                    <td class="border p-2"><?php echo $book['title']; ?></td>
                    <td class="border p-2"><?php echo $quantity; ?></td>
                    <td class="border p-2"><?php echo number_format($book['price'], 0, '.', ','); ?> تومان</td>
                    <td class="border p-2"><?php echo number_format($subtotal, 0, '.', ','); ?> تومان</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="border p-2 text-right">مجموع</td>
                <td class="border p-2"><?php echo number_format($total, 0, '.', ','); ?> تومان</td>
            </tr>
        </tbody>
    </table>
    <a href="../checkout.php" class="bg-blue-600 text-white p-2 mt-4 inline-block">تکمیل خرید</a>
<?php else: ?>
    <p>سبد خرید شما خالی است.</p>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>