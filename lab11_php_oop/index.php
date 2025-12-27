<?php

define('ROOT_PATH', __DIR__ . '/');
define('CLASS_PATH', ROOT_PATH . 'class/');
define('CONFIG_PATH', ROOT_PATH . 'config.php');
define('MODULE_PATH', ROOT_PATH . 'module/');
define('TEMPLATE_PATH', ROOT_PATH . 'template/');

if (!file_exists(CONFIG_PATH)) {
    die("Error: File konfigurasi " . CONFIG_PATH . " tidak ditemukan.");
}
include CONFIG_PATH;

include CLASS_PATH . "Database.php";
include CLASS_PATH . "Form.php";

session_start();

$db = new Database(); 

$request_uri = $_SERVER['REQUEST_URI'];
$base_url_len = strlen(BASE_URL);

if (substr($request_uri, 0, $base_url_len) == BASE_URL) {
    $path = substr($request_uri, $base_url_len);
} else {
    $path = trim(parse_url($request_uri, PHP_URL_PATH) ?? '', '/');
}

$path = strtok($path, '?');

$segments = explode('/', trim($path, '/'));

$mod = isset($segments[0]) && !empty($segments[0]) ? $segments[0] : 'home';

$page = isset($segments[1]) && !empty($segments[1]) ? $segments[1] : 'index';

$file = MODULE_PATH . "{$mod}/{$page}.php";

include TEMPLATE_PATH . "header.php";

if (file_exists($file)) {
    include $file;
} else {
    echo '<div class="alert alert-danger">Modul tidak ditemukan: ' . htmlspecialchars($mod) . 
    '/' . htmlspecialchars($page) . '</div>';
}

// Load Footer
include TEMPLATE_PATH . "footer.php";

?>