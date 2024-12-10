<?php
/**
 * Базовый класс для всех моделей
 */
?>

<?php
class Model {
    protected $table_name = '';
    protected $title = '';
    protected $ajax_entity = '';

    /**
     * @var Database
     */
    protected $database;

    /**
     * Получить все
     */
    public function get_all () {
        return $this->database->select_all();
    }

    /**
     * Создать
     * 
     * @param string $name
     */
    public function create ($names, $values) {
        return $this->database->insert($names, $values);
    }

    /**
     * Удалить
     * 
     * @param int $id
     */
    public function delete ($id) {
        $this->database->delete_where('id', $id);
    }

    /**
     * Изменить
     * 
     * @param array $key_value_arr
     * @param int $id
     */
    public function edit ($key_value_arr, $id) {
        $this->database->update_where($key_value_arr, 'id', $id);
    }

    /**
     * Получить названия колонок таблицы
     */
    public function get_columns () {
        return $this->database->get_columns();
    }

    /**
     * Получает последний использованный ID в таблице
     */
    public function last_use_id () {
        return $this->database->get_last_use_id()[0]['AUTO_INCREMENT'];
    }

    /**
     * Получить название Сущности
     */
    public function get_title () {
        return $this->title;
    }

    /**
     * Получить ajax параметр для будущих запросов
     */
    public function get_ajax_entity () {
        return $this->ajax_entity;
    }

    /**
     * Функция обработки ajax запроса
     * 
     * @param array $data
     */
    public function ajax ($data) {
        if ($data['action'] == 'edit'):
            $this->edit($data['values'], $data['id']);

        elseif ($data['action'] == 'delete'):
            $this->delete($data['id']);

        elseif ($data['action'] == 'create'):
            $this->create(array_keys($data['values']), array_values($data['values']));
        
        endif;

        return true;
    }

    /**
     * Получение данных о записи из текущей таблицы по ID
     * 
     * @param int $id
     */
    public function get_post_data ($id) {
        return $this->database->select_all_where('id', $id)[0];
    }

    /**
     * Получение данных о записи из переданной таблицы по ID
     * 
     * @param int $id
     * @param string $table_name
     * 
     */
    public function get_post_data_from_table ($id, $table_name) {
        $curr_table = $this->database->get_table_name();
        $this->database->set_table_name($table_name);
        $result = $this->database->select_all_where('id', $id)[0];
        $this->database->set_table_name($curr_table);
        return $result;
    }

    /**
     * Получить название колонки на русском
     * 
     * @param string $column_name
     */
    public function get_russion_column_name ($column_name) {
        switch ($column_name) {
            case 'name':
                return 'Название';

            case 'sku':
                return 'Артикул';

            case 'image':
                return 'Изображение';

            case 'price': 
                return 'Цена';

            case 'description':
                return 'Описание';

            case 'category_id':
                return 'Категория';

            case 'useful_element_id':
                return 'Полезный элемент';

            case 'soil_type_id':
                return 'Тип удобрения';

            case 'plant_type_id':
                return 'Тип растения';

            default:
                return $column_name;
        }
    }

    /**
     * Отображение инпутов
     * 
     * @param array $column_data
     * @param string $value
     * @param int $id
     */
    public function display_input ($column_data, $value, $id) {
        if (isset($column_data['REFERENCED_TABLE_NAME'])):
            $ref_table_name = $column_data['REFERENCED_TABLE_NAME'];
            $ref_col_name = $column_data['REFERENCED_COLUMN_NAME'];
            
            $curr_table = $this->database->get_table_name();
            $this->database->set_table_name($ref_table_name);
            $ref_table_data = $this->database->select_all();

            $ref_column_values = array();
            foreach ($ref_table_data as $elem):
                array_push($ref_column_values, [
                    $elem[$ref_col_name] => $elem['name']
                ]);
            endforeach;

            ob_start();?>
            <select name="<?= $column_data['COLUMN_NAME']; ?>" 
                id="<?= $column_data['COLUMN_NAME']; ?>"
                class="input-post-data"
                data-key="<?= $column_data['COLUMN_NAME'] ?>" 
                placeholder="<?= $this->get_russion_column_name($column_data['COLUMN_NAME']) ?>"
                >
                <?php foreach ($ref_column_values as $elem): ?>
                    <?php $id = array_keys($elem)[0]; ?>
                    <?php $name = array_values($elem)[0]; ?>
                    <option value="<?= $id; ?>" <?= !empty($value) ? ($id == $value ? "selected" : "") : "selected" ?>>
                        <?= $name ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php
            $html = ob_get_clean();
            echo $html;
            
            $this->database->set_table_name($curr_table);

        else:
            if ($column_data['DATA_TYPE'] == 'int'):
                ob_start();?>
                <input type="number" 
                        class="input-post-data"
                        value="<?= $value; ?>" 
                        data-id="<?= $id ?>" 
                        data-key="<?= $column_data['COLUMN_NAME'] ?>" 
                        placeholder="<?= $this->get_russion_column_name($column_data['COLUMN_NAME']) ?>"
                    >
                <?php
                $html = ob_get_clean();
                echo $html;

            elseif ($column_data['COLUMN_NAME'] == 'image'):
                ob_start();?>
                <input type="hidden"
                    class="input-post-data"
                    value="<?= !empty($value) ? base64_encode(file_get_contents($value)) : ''; ?>" 
                    data-id="" 
                    data-key="<?= $column_data['COLUMN_NAME'] ?>" 
                    placeholder="<?= $this->get_russion_column_name($column_data['COLUMN_NAME']) ?>"
                    >
                <input type="file">
                <img src="<?= $value ?>" class="image_preview" alt="image-preview"></img>
                <?php
                $html = ob_get_clean();
                echo $html;

            else:
                ob_start();?>
                <input type="text" 
                        class="input-post-data"
                        value="<?= $value ?>" 
                        data-id="<?= $id ?>" 
                        data-key="<?= $column_data['COLUMN_NAME'] ?>" 
                        placeholder="<?= $this->get_russion_column_name($column_data['COLUMN_NAME']) ?>"
                    >
                <?php
                $html = ob_get_clean();
                echo $html;

            endif;

        endif;
    }

    /**
     * Получить значение колонки записи по имени колонки
     * 
     * @param string $column_name
     */
    public function get_value_by_column_name ($column_name, $post_data) {
        foreach ($post_data as $key => $value):
            if ($key == $column_name):
                return $value;
            endif;
        endforeach;
    }
}
?>