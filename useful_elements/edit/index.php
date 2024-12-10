<?php include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "autoload.php") ?>

<?php get_header(); ?>

<?php
$view_useful_elements = new View_Useful_Elements();
$view_useful_elements->display_edit();
?>

<?php get_footer(); ?>