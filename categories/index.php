<?php include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "autoload.php") ?>

<?php get_header(); ?>

<?php
$view_categories = new View_Categories();
$view_categories->display();
?>

<?php get_footer(); ?>