<?php
$columns = $this->get_columns();
$all_elems = $this->get_all();
$title = $this->get_title();
$ajax_entity = $this->get_ajax_entity();
$last_use_id = $this->last_use_id();

if ($ajax_entity == 'product'):?>
    <style>
        .container {
            width: 3000px;
            overflow: auto;
            padding-left: 30px;
        }
    </style>
<?php
endif;
?>

<style>
    .entities__table {
        display: flex;
        flex-direction: column;
        margin-top: 50px;
        transition: all .4s;
        border-bottom: 1px solid #dfdfdf;;
    }

    .entities__table.preload {
        opacity: .3;
        pointer-events: none;
    }

    .entities__table__row {
        display: grid;
        grid-template-columns: repeat(<?= count($columns) + 2 ?>, 1fr);
        border: 1px solid #dfdfdf;
        border-bottom: none;
        padding: 20px 10px;
        transition: all .3s;
    }

    .entities__table__row-head__ceil {
        font-size: 20px;
        font-weight: 600;
    }

    .entities__table__row__ceil {
        display: flex;
        align-items: center;
        justify-content: start;
    }

    .entities__table__row__ceil input {
        font-size: 16px;
        border: none;
        width: 100%;
    }

    .entities__table__row__ceil input.edit {
        border: 1px solid #000;
    }

    .entities__table__row__ceil-edit span {
        padding: 10px 20px;
        background: #017BFF;
        border-radius: 5px;
        color: #fff;
        transition: all .3s;
        cursor: pointer;
    }

    .entities__table__row__ceil-edit span:hover {
        opacity: .6;
    }

    .entities__table__row__ceil-delete span {
        padding: 10px 20px;
        background: #DE3644;
        border-radius: 5px;
        color: #fff;
        transition: all .3s;
        cursor: pointer;
    }

    .entities__table__row__ceil-delete span:hover {
        opacity: .6;
    }

    .entities__add-new {
        padding: 10px 20px;
        background: #017BFF;
        color: #fff;
        cursor: pointer;
        border-radius: 5px;
        transition: all .3s;
        margin-top: 30px;
        display: inline-block;
    }

    .entities__add-new:hover {
        opacity: .6;
    }

    .entities__table__row-new-template {
        display: none;
    }
</style>

<div class="container entities">
    <h1>
        Доступные элементы: <?= $title ?>
    </h1>
    <div class="entities__table">
        <input type="hidden" name="last_use_id" id="last_use_id" value="<?= $last_use_id; ?>">
        <div class="entities__table__row entities__table__row-head">
            <?php foreach ($columns as $col): ?>
                <div class="entities__table__row-head__ceil">
                    <?= $this->get_russion_column_name($col['COLUMN_NAME']); ?>
                </div>
            <?php endforeach; ?>
            <div class="entities__table__row-head__ceil">
            </div>
            <div class="entities__table__row-head__ceil">
            </div>
        </div>
        <?php foreach ($all_elems as $elem): ?>
            <?php $id = $elem['id']; ?>
            <div class="entities__table__row" data-id="<?= $id ?>">
                <?php foreach ($columns as $col): ?>
                    <?php 
                    $is_reference = isset ($col['REFERENCED_TABLE_NAME']) ? true : false;
                    $key = $col['COLUMN_NAME'];
                    $value = $this->get_value_by_column_name($key, $elem);
                    if ($is_reference): 
                        $value = $this->get_post_data_from_table($this->get_value_by_column_name($key, $elem), $col['REFERENCED_TABLE_NAME'])['name'];
                    endif;

                    if ($col['COLUMN_NAME'] == 'image'):?>
                        <div class="entities__table__row__ceil">
                            <img src="<?= $value ?>" 
                                alt="prod_img" 
                                data-id="<?= $id; ?>" 
                                data-key="<?= $key ?>"
                                style="width: 100px; height: 100px; object-fit: cover"
                                >
                        </div>
                    
                    <?php
                    else:?>
                        <div class="entities__table__row__ceil">
                            <input type="text" value="<?= htmlspecialchars($value) ?>" data-id="<?= $id; ?>" data-key="<?= $key ?>" readonly>
                        </div>
                    <?php
                    endif;
                    ?>
                <?php endforeach; ?>
                <a href="<?= $_SERVER['REQUEST_URI']; ?>edit?post_id=<?= $elem['id'] ?>" class="entities__table__row__ceil entities__table__row__ceil-edit" 
                    data-id="<?= $id; ?>" 
                    data-is_edit="0" 
                    onclick="edit_entity(event)"
                    data-entity="<?= $ajax_entity; ?>"
                    data-action="edit">
                    <span>Редактировать</span>
                </a>
                <div class="entities__table__row__ceil entities__table__row__ceil-delete" 
                    data-id="<?= $id; ?>" 
                    onclick="delete_entity(event)"
                    data-entity="<?= $ajax_entity; ?>">
                    <span>Удалить</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="<?= $_SERVER['REQUEST_URI']; ?>create" class="entities__add-new">
        Создать
    </a>
</div>

<script>
    // Функция отправляет ajax запрос на изменение/удаление выбранной сущности
    function request_to_edit_entity (data) {
        let edit_entity_request_promise = new Promise((resolve, reject) => {
            document.querySelector(`.entities__table`).classList.add('preload');

            const xhr = new XMLHttpRequest();

            xhr.open('POST', "/ajax/admin-ajax.php" , true);

            xhr.responseType = 'json';

            xhr.onload = function () {
                resolve(xhr.response);
            }

            let form_data = new FormData();
            form_data.append('data', JSON.stringify(data));
            
            xhr.send(form_data);
        });

        edit_entity_request_promise.then(result => {
            document.querySelector(`.entities__table`).classList.remove('preload');
        });
    }

    // Удаление сущности
    function delete_entity (e) {
        const target = e.currentTarget;
        const id = target.getAttribute('data-id');
        const entity = target.getAttribute('data-entity');
        let data = {
            'entity': entity,
            'action': 'delete',
            'id': id
        };

        request_to_edit_entity(data);
        document.querySelector(`.entities__table__row[data-id="${id}"]`).style.display = 'none';
    }
</script>