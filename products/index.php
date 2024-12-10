<?php include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "autoload.php") ?>

<?php get_header(); ?>

<?php
$view_products = new View_Products();
$view_products->display();
?>

<?php get_footer(); ?>