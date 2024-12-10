
<?php include "autoload.php" ?>

<?php get_header(); ?>

<?php 
$view_main = new View_Main();
$view_main->display(); 
?>

<?php get_footer(); ?>