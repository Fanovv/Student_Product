<?php

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');

include_once '../../models/student.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($student->validate_params($_POST['name'])) {
        $student->name = $_POST['name'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Name is required!'));
        die();
    }

    if ($student->validate_params($_POST['email'])) {
        $student->email = $_POST['email'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Email is required!'));
        die();
    }

    if ($student->validate_params($_POST['password'])) {
        $student->password = $_POST['password'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Password is required!'));
        die();
    }

    if ($student->validate_params($_POST['address'])) {
        $student->address = $_POST['address'];
    } else {
        echo json_encode(array('success' => 0, 'message' => 'Address is required!'));
        die();
    }

    if ($student->check_unique_email()) {
        if ($id = $student->register_student()) {
            echo json_encode(array('success' => 1, 'message' => 'Student registered'));
        } else {
            http_response_code(500);
            echo json_encode(array('success' => 0, 'message' => 'Internal Server Error!'));
        }
    } else {
        http_response_code(401);
        echo json_encode(array('success' => 0, 'message' => 'Email already exists!'));
    }
} else {
    die(header('HTTP/1.1 405 Request Method Not Allowed'));
}
