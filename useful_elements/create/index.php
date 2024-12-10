<?php include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "autoload.php") ?>

<?php get_header(); ?>

<?php
$useful_elements = new View_Useful_Elements();
$useful_elements->display_create();
?>

<?php get_footer(); ?>