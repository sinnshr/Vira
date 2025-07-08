<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            background-color: #e8e3c1;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">
    <?php include 'header.php'; ?>
    <main class="flex-1 p-0 m-0">
        <?php if (isset($content))
            echo $content; ?>
    </main>
    <?php include 'footer.php'; ?>
</body>

</html>