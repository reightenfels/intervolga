<?php
$ajax_entity = $this->get_ajax_entity();
$columns = $this->get_columns();
$title = $this->get_title();
?>

<style>
    .container {
        width: 50%;
    }

    .create.preload {
        opacity: .4;
        pointer-events: none;
    }

    .create__block {
        margin-top: 30px;
    }

    .create__label {
        font-size: 25px;
    }

    .create__block input, .create__block select {
        border: 1px solid #dfdfdf;
        padding: 0 20px;
        width: 100%;
        height: 45px;
        font-size: 16px;
        margin-top: 10px;
    }

    .create__save {
        padding: 10px 20px;
        background: #017BFF;
        border-radius: 5px;
        color: #fff;
        transition: all .3s;
        cursor: pointer;
        margin-top: 50px;
        display: inline-block;
    }

    .create__save:hover {
        opacity: .6;
    }

    .image_preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        display: none;
    }
</style>

<div class="container create">
    <h1>Создание записи в таблице "<?= $title; ?>"</h1>
    <?php foreach ($columns as $col): ?>
        <?php $col_name = $col['COLUMN_NAME']; ?>
        <?php $is_reference = isset ($col['REFERENCED_TABLE_NAME']) ? true : false; ?>
        <?php $col_type = isset($col['DATA_TYPE']) ? $col['DATA_TYPE'] : false; ?>
        <?php if ($col_name == 'id') continue; ?>
        <div class="create__block">
            <div class="create__label">
                <?= $this->get_russion_column_name($col_name); ?>
            </div>
            <div class="create__field">
                <?php $this->display_input($col, '', '', ''); ?>
            </div>
        </div>        
    <?php endforeach; ?>
    <div class="create__save"
        data-id="" 
        onclick="create_entity(event)"
        data-entity="<?= $ajax_entity; ?>"
        data-action="create">
        Создать
    </div>
</div>

<script>
    // Функция отправки запроса на изменение записи
    function request_to_edit_entity (data) {
        let edit_entity_request_promise = new Promise((resolve, reject) => {
            document.querySelector(`.create`).classList.add('preload');

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
            document.querySelector(`.create`).classList.remove('preload');
        });
    }

    // Функция добавления небходимых данных
    function create_entity (e) {
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
            'action': action
        };

        let key_value = {};

        for (elem of inputs) {
            key_value[`${elem.getAttribute('data-key')}`] = elem.value;
        }

        data['values'] = key_value;

        request_to_edit_entity(data);

        for (elem of inputs) {
            elem.value = '';
        }

        document.querySelector('input[type="file"]').value = '';
        document.querySelector('.image_preview').style.display = 'none';
    }

    // Отображение изображения при загрузке
    document.querySelector('input[type="file"]').addEventListener('change', function (e) {
        const target = e.currentTarget;
        let file_reader = new FileReader();

        file_reader.addEventListener('load', function () {
            const result = file_reader.result;
            document.querySelector('.image_preview').style.display = 'block';
            document.querySelector('.image_preview').src = result;
            
            const base64 = result.split(',')[1];
            console.log(base64);
            target.parentNode.querySelector('.input-post-data').value = base64;
        });

        file_reader.readAsDataURL(target.files[0]);
    });
</script>