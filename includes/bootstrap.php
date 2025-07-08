<?php
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/../src/db.php';
require_once __DIR__ . '/../src/auth.php';
require_once __DIR__ . '/../src/book.php';
require_once __DIR__ . '/../src/cart.php';
require_once __DIR__ . '/../src/user.php';

function renderPage($content = '', $pageTitle = 'ویرا - هر صفحه یک جهان')
{
    includeLayout($pageTitle, $content);
}

function includeLayout($pageTitle, $content)
{
    include __DIR__ . '/layout.php';
    exit;
}