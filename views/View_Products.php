<?php
/**
 * Класс для отображения элементов "Продукция"
 */

class View_Products extends Product {
    public function display () {
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'entities.php');
    }

    public function display_edit () {
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'edit.php');
    }

    public function display_create () {
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'create.php');
    }
}
?>