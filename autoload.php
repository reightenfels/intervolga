<?php
function get_header () {
    include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'header.php');
}

function get_footer () {
    include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'footer.php');
}

spl_autoload_register(function ($class_name) {
    $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . $class_name . '.php';

    if (file_exists($path)) include $path;
});

spl_autoload_register(function ($class_name) {
    $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . $class_name . '.php';

    if (file_exists($path)) include $path;
});

spl_autoload_register(function ($class_name) {
    $path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $class_name . '.php';

    if (file_exists($path)) include $path;
});
?>