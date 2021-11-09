<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');

include_once '../../models/product.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($product->validate_params($_POST['id'])) {
        $product->id = $_POST['id'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Student ID is required!'));
        die();
    }

    if ($product->validate_params($_POST['name'])) {
        $product->name = $_POST['name'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Name is required!'));
        die();
    }

    $product_images_folder = '../../assets/product_image/';

    if (!is_dir($product_images_folder)) {
        mkdir($product_images_folder);
    }

    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $tmp = explode('.', $file_name);
        $extension = end($tmp);

        $new_file_name = $product->id . "_product_" . $product->name . "." . $extension;

        move_uploaded_file($file_tmp, $product_images_folder . "/" . $new_file_name);

        $product->image = 'product_image/' . $new_file_name;

    } else {
        echo json_encode(array('success' => 0, 'message' => 'Image is required!'));
        die();
    }

    if ($product->validate_params($_POST['price'])) {
        $product->price = $_POST['price'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Price is required!'));
        die();
    }

    if ($product->validate_params($_POST['description'])) {
        $product->description = $_POST['description'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Description is required!'));
        die();
    }

    if ($product->add_product()) {
        echo json_encode(array('success' => 1, 'message' => 'Product successfully added!'));
    } else {
        http_response_code(500);
        echo json_encode(array('success' => 0, 'message' => 'Internal server error'));
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
