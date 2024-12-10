<?php
$post_id = $_GET['post_id'];
$entity_title = $this->get_title();
$post_data = $this->get_post_data($post_id);
$post_title = $post_data['name'];
$ajax_entity = $this->get_ajax_entity();
$columns = $this->get_columns();
?>

<style>
    .container {
        width: 50%;
    }

    .edit.preload {
        opacity: .4;
        pointer-events: none;
    }

    .edit__block {
        margin-top: 30px;
    }

    .edit__label {
        font-size: 25px;
    }

    .edit__block input, .edit__block select {
        border: 1px solid #dfdfdf;
        padding: 0 20px;
        width: 100%;
        height: 45px;
        font-size: 16px;
        margin-top: 10px;
    }

    .edit__save {
        padding: 10px 20px;
        background: #017BFF;
        border-radius: 5px;
        color: #fff;
        transition: all .3s;
        cursor: pointer;
        margin-top: 50px;
        display: inline-block;
    }

    .edit__save:hover {
        opacity: .6;
    }

    .image_preview {
        width: 100px;
        height: 100px;
    }
</style>

<div class="container edit">
    <h1><?= $entity_title ?>: "<?= $post_title; ?>"</h1>
    <?php foreach ($columns as $col): ?>
        <?php $col_name = $col['COLUMN_NAME']; ?>
        <?php $is_reference = isset ($col['REFERENCED_TABLE_NAME']) ? true : false; ?>
        <?php $col_type = isset($col['DATA_TYPE']) ? $col['DATA_TYPE'] : false; ?>
        <?php if ($col_name == 'id') continue; ?>
        <div class="edit__block">
            <div class="edit__label">
                <?= $this->get_russion_column_name($col_name); ?>
            </div>
            <div class="edit__field">
                <?php $this->display_input($col, $post_data[$col_name], $post_data['id']); ?>
            </div>
        </div>        
    <?php endforeach; ?>
    <div class="edit__save"
        data-id="" 
        onclick="edit_entity(event)"
        data-entity="<?= $ajax_entity; ?>"
        data-action="edit">
        Создать
    </div>
</div>

<script>
    function request_to_edit_entity (data) {
        let edit_entity_request_promise = new Promise((resolve, reject) => {
            document.querySelector(`.edit`).classList.add('preload');

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
            console.log(result);
            document.querySelector(`.edit`).classList.remove('preload');
        });
    }

    function edit_entity (e) {
        let inputs = document.querySelectorAll('.input-post-data');
        for (elem of inputs) {
            if (elem.value == '') {
                alert (`Заполните ${elem.getAttribute('placeholder')}`);
                return false;
            }
        }

        const target = e.currentTarget;
        const id = target.getAttribute('data-id');
        const entity = target.getAttribute('data-entity');
        const action = target.getAttribute('data-action');

        let data = {
            'entity': entity,
            'action': action,
            'id': <?= $post_id ?>
        };

        let key_value = {};

        for (elem of inputs) {
            key_value[`${elem.getAttribute('data-key')}`] = elem.value;
        }

        data['values'] = key_value;

        request_to_edit_entity(data);
    }
</script>