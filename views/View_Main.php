<?php
class View_Main {
    public function display () {
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'main.php');
    }
}
?>