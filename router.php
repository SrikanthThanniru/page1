<?php
// Local preview only:  php -S localhost:8000 router.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (preg_match('#^/(projects/)?sparkle-haven-villa-east-hyderabad/?$#', $path) || $path === '/') {
    require __DIR__ . '/sparkle-haven-villa-east-hyderabad.php';
    return true;
}
return false;
