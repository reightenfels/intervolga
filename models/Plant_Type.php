<?php
/**
 * Сущность базы данных "Тип растений"
 */


class Plant_Type extends Model {
    protected $table_name = 'тип_растений';
    protected $title = 'Тип растений';
    protected $ajax_entity = 'plant_type';

    /**
     * Конструктор
     */
    public function __construct () {
        $this->database = new Database($this->table_name);
        $this->database->set_connection('root', 'root');
    }
}
?>