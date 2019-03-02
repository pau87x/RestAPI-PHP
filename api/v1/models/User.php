<?php 
include('BaseModel.php');

class User extends BaseModel {
    private $table = "useritems";
    public $fields = ["id", "name", "username", "email"];

    public function __construct(){
        parent::__construct($this->table, $this->fields);
    }
}