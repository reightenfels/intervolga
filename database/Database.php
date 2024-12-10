<?php
/**
 * Класс взаимодействия с базой данных
 */

class Database {
    private $db_object = null;
    private $db_type;
    private $db_host;
    private $db_name;
    private $table_name;

    /**
     * Конструктор
     * 
     * @param string $table_name
     */
    public function __construct ($table_name = '') {
        $this->db_type = 'mysql';
        $this->db_host = 'localhost';
        $this->db_name = 'intervolga';
        $this->table_name = $table_name;
    }

    /**
     * Установка типа БД
     * 
     * @param string $type
     */
    public function set_db_type ($type) {
        $this->db_type = $type;
    }

    /**
     * Установка хоста
     * 
     * @param string $host
     */
    public function set_localhost ($host) {
        $this->db_host = $host;
    }

    /**
     * Установка имени БД
     * 
     * @param string $name
     */
    public function set_db_name ($name) {
        $this->db_name = $name;
    }

    /**
     * Установка соединения
     * 
     * @param string $login
     * @param string $password
     */
    public function set_connection ($login, $password) {
        try {
            $this->db_object = new PDO($this->db_type . ':dbname=' . $this->db_name . ';host=' . $this->db_host, $login, $password);
        }
        catch (Exception $e) {
            echo($e);
            return false;
        }
    }

    /**
     * Установка названия таблицы
     * 
     * @param string $table_name
     */
    public function set_table_name ($table_name) {
        $this->table_name = $table_name;
    }

    /**
     * Получение названия таблицы
     */
    public function get_table_name () {
        return $this->table_name;
    }

    /**
     * Выборка всех записей из таблицы
     * 
     */
    public function select_all ($type = 'assoc') {
        try {
            $query_string = 'SELECT * FROM `' . $this->table_name . '`';
            $query = $this->db_object->prepare($query_string);
            $query->execute();
            $result = null;
            if ($type == 'assoc'):
                $result = $query->fetchAll(PDO::FETCH_ASSOC);

            elseif ($type == 'both'):
                $result = $query->fetchAll(PDO::FETCH_BOTH);

            endif;

            return $result;
        }
        catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * Выборка из таблицы с условием
     * 
     * @param string $key
     * @param string $value
     */
    public function select_all_where ($key, $value) {
        try {
            $query_string = 'SELECT * FROM `' . $this->table_name . '` WHERE ' . $key . '="' . $value . '"';
            $query = $this->db_object->prepare($query_string);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * Обновление данных таблицы
     * 
     * @param array $key_value_arr
     * @param array $where
     */
    public function update_where ($key_value_arr, $where_key, $where_value) {
        try {
            $query_string = 'UPDATE `' . $this->table_name . '` SET ';

            $count = 1;
            foreach ($key_value_arr as $key => $value):
                $query_string .= $key . '="' . $value . '"';

                if ($count != count($key_value_arr)) $query_string .= ',';

                $count += 1;
            endforeach;

            $query_string .= ' WHERE ' . $where_key . '="' . $where_value . '"';

            $query = $this->db_object->prepare($query_string);
            $query->execute();

            return true;
        }
        catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * Вставка записи в таблицу
     * 
     * @param array $names
     * @param array $values
     */
    public function insert ($names, $values) {
        try {
            $query_string = 'INSERT INTO `' . $this->table_name . '`(' . implode(",", $names) . ') VALUES(' . 
            implode(",", array_map(function ($elem) {return "\"$elem\"";}, $values)) . ')';
            $query = $this->db_object->prepare($query_string);
            $query->execute();
            return true;
        }
        catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * Удаление записи из таблицы с условием
     * 
     * @param string $key
     * @param string $value
     */
    public function delete_where ($key, $value) {
        try {
            $query_string = 'DELETE FROM `' . $this->table_name .'` WHERE ' . $key .'="' . $value . '"';
            $query = $this->db_object->prepare($query_string);
            $query->execute();
            return true;
        }
        catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * Колонки таблицы
     */
    public function get_columns () {
        try {
            $query_string = 'SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = "' . $this->table_name . '"';
            $query = $this->db_object->prepare($query_string);
            $query->execute();
            $all_columns = $query->fetchAll(PDO::FETCH_ASSOC);

            $query_string = 'SELECT * FROM INFORMATION_SCHEMA.key_column_usage WHERE TABLE_NAME = "' . $this->table_name . '"';
            $query = $this->db_object->prepare($query_string);
            $query->execute();
            $key_column_usage = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($all_columns as $elem):
                $is_in_array = false;
                foreach ($key_column_usage as $key => $usage_elem):
                    if ($usage_elem['COLUMN_NAME'] == $elem['COLUMN_NAME']) $is_in_array = true;
                    if (isset($usage_elem['CONSTRAINT_NAME']) && $usage_elem['CONSTRAINT_NAME'] == 'PRIMARY') unset($key_column_usage[$key]);
                endforeach;
                if (!$is_in_array) array_push($key_column_usage, $elem);
            endforeach;

            return $key_column_usage;
        }
        catch (Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * Получает последний использованный ID в таблице
     */
    public function get_last_use_id () {
        try {
            $query_string = 'SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "intervolga" AND TABLE_NAME = "' . $this->table_name . '"';
            $query = $this->db_object->prepare($query_string);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (Exception $e) {
            echo $e;
            return false;
        }
    }
}
?>