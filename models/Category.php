<?php
/**
 * Сущность базы данных "Вид продукции"
 */

class Category extends Model {
    protected $table_name = 'виды_продукции';
    protected $title = 'Виды продукции';
    protected $ajax_entity = 'category';

    /**
     * Конструктор
     */
    public function __construct () {
        $this->database = new Database($this->table_name);
        $this->database->set_connection('root', 'root');
    }
}
?>