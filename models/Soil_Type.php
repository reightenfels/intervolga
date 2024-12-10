<?php
/**
 * Сущность базы данных "Тип удобрения"
 */

class Soil_Type extends Model {
    protected $table_name = 'тип_удобрения';
    protected $title = 'Тип удобрений';
    protected $ajax_entity = 'soil_type';

    /**
     * Конструктор
     */
    public function __construct () {
        $this->database = new Database($this->table_name);
        $this->database->set_connection('root', 'root');
    }
}
?>