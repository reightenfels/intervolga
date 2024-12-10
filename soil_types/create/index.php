<?php include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "autoload.php") ?>

<?php get_header(); ?>

<?php
$view_soil_types = new View_Soil_Types();
$view_soil_types->display_create();
?>

<?php get_footer(); ?>