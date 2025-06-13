<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/auth.php';

$rootPath = realpath(__DIR__ . '/../');
$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->safeLoad();

$client = new Google\Client;

if (!isset($_ENV['GOOGLE_CLIENT_REDIRECT_URI']) || empty($_ENV['GOOGLE_CLIENT_REDIRECT_URI'])) {
    die('Error: GOOGLE_CLIENT_REDIRECT_URI is not set or empty in the .env file');
}

$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_CLIENT_REDIRECT_URI']);

if (!isset($_GET['code'])) {
    // Redirect to error page if code is missing
    header("Location: public/google_error.php?msg=" . urlencode("درخواست نامعتبر یا URL اشتباه است."));
    exit;
}

$httpClient = new GuzzleHttp\Client([
    'verify' => __DIR__ . '/../cacert.pem'
]);

// Set the custom HTTP client for the Google Client
$client->setHttpClient($httpClient);

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
if (isset($token['error'])) {
    // Redirect to error page if token fetch fails
    header("Location: public/google_error.php?msg=" . urlencode("خطا در دریافت توکن گوگل."));
    exit;
}
$client->setAccessToken($token['access_token']);
$oauth = new Google\Service\Oauth2($client);
$userinfo = $oauth->userinfo->get();

$email = $userinfo->email ?? null;
$name = $userinfo->name ?? null;
$google_id = $userinfo->id ?? null;

if (!$email || !$google_id) {
    // Redirect to error page if user info is incomplete
    header("Location: public/google_error.php?msg=" . urlencode("اطلاعات کاربری گوگل ناقص است."));
    exit;
}

// Try to login or register the user
$success = loginOrRegisterWithGoogle($google_id, $email, $name);

if ($success) {
    // Session is already set by loginOrRegisterWithGoogle()
    header("Location: public/books.php");
    exit;
} else {
    header("Location: public/google_error.php?msg=" . urlencode("ورود با گوگل ناموفق بود."));
    exit;
}