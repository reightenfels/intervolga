<?php include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "autoload.php") ?>

<?php get_header(); ?>

<?php
$view_plain_types = new View_Plant_Types();
$view_plain_types->display_edit();
?>

<?php get_footer(); ?>