<?php
/**
 * Сущность базы данных "Продукция"
 */

class Product extends Model {
    protected $table_name = 'продукция';
    protected $title = 'Продукция';
    protected $ajax_entity = 'product';

    /**
     * Конструктор
     */
    public function __construct () {
        $this->database = new Database($this->table_name);
        $this->database->set_connection('root', 'root');
    }
}
?>