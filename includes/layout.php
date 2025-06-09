<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @font-face {
            font-family: 'Dana';
            src: url('/assets/fonts/DANA-MEDIUM.TTF') format('TTF');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        body {
            font-family: 'Dana', 'Tahoma', 'Arial', sans-serif;
            background-color: #FEFAE0;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <main class="p-0 m-0">
        <?php if (isset($content)) {
            echo $content;
        } ?>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>