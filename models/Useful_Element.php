<?php
/**
 * Сущность базы данных "Полезные элементы"
 */

class Useful_Element extends Model {
    protected $table_name = 'полезные_элементы';
    protected $title = 'Полезные элементы';
    protected $ajax_entity = 'useful_element';

    /**
     * Конструктор
     */
    public function __construct () {
        $this->database = new Database($this->table_name);
        $this->database->set_connection('root', 'root');
    }
}
?>