<?php
include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'Database.php');
include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Model.php');

$data = json_decode(stripslashes($_POST['data']), true);
$entity = $data['entity'];

switch ($entity) {
    case 'product':
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Product.php');
        $product = new Product();

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, base64_decode($data['values']['image']));
        rewind($stream);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/' . 'uploads' . '/' . time() . '.jpg', $stream);

        $data['values']['image'] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . 'uploads' . '/' . time() . '.jpg';

        $response = $product->ajax($data);

        fclose($stream);

        echo json_encode($response);
        break;

    case 'category':
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Category.php');
        $category = new Category();

        $response = $category->ajax($data);

        echo json_encode($response);
        break;

    case 'plant_type':
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Plant_Type.php');
        $plant_type = new Plant_Type();

        $response = $plant_type->ajax($data);

        echo json_encode($response);
        break;

    case 'soil_type':
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Soil_Type.php');
        $soil_type = new Soil_Type();

        $response = $soil_type->ajax($data);

        echo json_encode($response);
        break;

    case 'useful_element':
        include ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Useful_Element.php');
        $useful_element = new Useful_Element();

        $response = $useful_element->ajax($data);

        echo json_encode($response);
        break;
}
?>