<?php
/**
 * Класс для отображения элементов "Тип удобрений"
 */

class View_Soil_Types extends Soil_Type {
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