<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: GET');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');

include_once '../../models/product.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($product->validate_params($_GET['id'])) {
        $product->id = $_GET['id'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Student ID is required!'));
        die();
    }

    if ($product->get_products_per_student() == null) {
        echo json_encode(array('success' => 0, 'message' => 'Product is empty!'));
    } else {
        echo json_encode(array('success' => 1, 'product' => $product->get_products_per_student()));
    }

} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
