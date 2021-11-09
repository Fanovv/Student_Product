<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__) . $ds . '..') . $ds;

require_once "{$base_dir}includes{$ds}database.php";
require_once "{$base_dir}includes{$ds}bcrypt.php";

class Student
{
    private $table = 'student';

    public $id;
    public $name;
    public $email;
    public $password;
    public $address;

    public function __construct()
    {

    }

    public function validate_params($value)
    {

        return (!empty($value));

    }

    public function check_unique_email()
    {
        global $database;

        $this->email = trim(htmlspecialchars(strip_tags($this->email)));

        $sql = "SELECT id FROM $this->table WHERE email = '" . $database->escape_value($this->email) . "'";

        $result = $database->query($sql);
        $user_id = $database->fetch_row($result);

        return empty($user_id);
    }

    public function register_student()
    {
        global $database;

        $this->name = trim(htmlspecialchars(strip_tags($this->name)));
        $this->email = trim(htmlspecialchars(strip_tags($this->email)));
        $this->password = trim(htmlspecialchars(strip_tags($this->password)));
        $this->address = trim(htmlspecialchars(strip_tags($this->address)));

        $sql = "INSERT INTO $this->table (name, email, password, address) VALUES (
            '" . $database->escape_value($this->name) . "',
            '" . $database->escape_value($this->email) . "',
            '" . $database->escape_value(Bcrypt::hashPassword($this->password)) . "',
            '" . $database->escape_value($this->address) . "'
            )";

        $student_saved = $database->query($sql);

        if ($student_saved) {
            return true;
        } else {
            return false;
        }
    }

    public function login()
    {
        global $database;

        $this->email = trim(htmlspecialchars(strip_tags($this->email)));
        $this->password = trim(htmlspecialchars(strip_tags($this->password)));

        $sql = "SELECT * FROM $this->table WHERE email = '" . $database->escape_value($this->email) . "'";

        $result = $database->query($sql);
        $student = $database->fetch_row($result);

        if (empty($student)) {
            return "Student doesn't exists!";
        } else {
            if (Bcrypt::checkPassword($this->password, $student['password'])) {
                unset($student['password']);
                return $student;
            } else {
                return "Password doesn't match!";
            }

        }
    }

    public function all_student()
    {
        global $database;

        $sql = "SELECT id, name, address FROM $this->table";

        $result = $database->query($sql);

        return $database->fetch_array($result);
    }
}

$student = new Student();
