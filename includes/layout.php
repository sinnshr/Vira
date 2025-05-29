<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'ویرا - هر صفحه یک جهان'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@^3/dist/tailwind.min.css" rel="stylesheet">
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
<body>
    <?php include 'header.php'; ?>

    <main class="p-0 m-0">
        <?php if (isset($content)) { echo $content; } ?>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>