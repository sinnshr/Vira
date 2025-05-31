<?php
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/db.php';

function renderPage($content = '', $pageTitle = 'ویرا - هر صفحه یک جهان') {
    global $pageTitle;
    ob_start();
    echo $content;
    $content = ob_get_clean();
    includeLayout($pageTitle, $content);
}

function includeLayout($pageTitle, $content) {
    include __DIR__ . '/layout.php';
    exit; 
}