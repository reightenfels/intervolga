<?php include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "autoload.php") ?>

<?php get_header(); ?>

<?php
$view_plant_types = new View_Plant_Types();
$view_plant_types->display();
?>

<?php get_footer(); ?>