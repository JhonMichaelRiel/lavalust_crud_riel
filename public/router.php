<?php

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

if ($path !== '/' && $path !== '/index.php') {
    $file = __DIR__ . $path;
    if (is_file($file)) {
        return false;
    }
}

if (str_starts_with($path, '/index.php/')) {
    $_SERVER['REQUEST_URI'] = substr($path, strlen('/index.php'));
}

require __DIR__ . '/index.php';
