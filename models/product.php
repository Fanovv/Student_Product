<?php

$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__) . $ds . '..') . $ds;

require_once "{$base_dir}includes{$ds}database.php";

class Product
{
    private $table = 'product';

    public $id_product;
    public $id;
    public $name;
    public $image;
    public $price;
    public $description;
    public $interaction_count;

    public function __construct()
    {

    }

    public function validate_params($value)
    {
        return (!empty($value));
    }

    public function add_product()
    {
        global $database;

        $this->id = trim(htmlspecialchars(strip_tags($this->id)));
        $this->name = trim(htmlspecialchars(strip_tags($this->name)));
        $this->image = trim(htmlspecialchars(strip_tags($this->image)));
        $this->price = trim(htmlspecialchars(strip_tags($this->price)));
        $this->description = trim(htmlspecialchars(strip_tags($this->description)));

        $sql = "INSERT INTO $this->table (id, name, image, price, description) VALUES (
            '" . $database->escape_value($this->id) . "',
            '" . $database->escape_value($this->name) . "',
            '" . $database->escape_value($this->image) . "',
            '" . $database->escape_value($this->price) . "',
            '" . $database->escape_value($this->description) . "'
        )";

        $result = $database->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_products_per_student()
    {
        global $database;

        $this->id = trim(htmlspecialchars(strip_tags($this->id)));

        $sql = "SELECT * FROM $this->table WHERE id = '" . $database->escape_value($this->id) . "'";

        $result = $database->query($sql);

        return $database->fetch_array($result);
    }
}

$product = new Product();
