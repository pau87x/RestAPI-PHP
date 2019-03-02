<?php

include('../DBAccess.php');

class BaseModel{
    private $table;
    public $fields = [];
    private $query_fields;
    protected $db;

    public function __construct($table, $fields){
        $this->table = $table;
        $this->fields = $fields;
        $this->query_fields = implode(",", $fields);
        $this->db = DBAccess::getAccess();
    }
    
    function getAll(){
        $query = "SELECT $this->query_fields 
                    FROM $this->table";
        $field = [];
        return $this->db->getData($query,$field);
    }

    function getById($id){
        $query = "SELECT $this->query_fields 
                    FROM $this->table 
                    WHERE id= :id";
        $field = ["id"=>$id];
        return $this->db->getData($query,$field);
    }

    function insert($values){
        $fields = $this->removeIdField($this->fields);

        $query_values = $this->queryParamsInsert($values);

        $query = "INSERT INTO $this->table 
                    ($fields) 
                VALUES ($query_values)";
        return $this->db->postData($query,$values);
    }

    function updateById($id,$values){
        $query_values = $this->queryParams($values);

        $query = "UPDATE 
                        $this->table 
                    SET 
                        $query_values
                    WHERE id=:id";
        $values["id"] = $id;

        return $this->db->postData($query,$values);
    }

    function deleteById($id){
        $query = "DELETE FROM $this->table WHERE id=:id";

        $field = ["id"=>$id];

        return $this->db->postData($query,$field);
    }

    //Helpers
    function queryParams($data){
        foreach($data as $key => $value){
            $params .= "$key=:$key,";
        }
        $params = substr($params, 0, -1);
        return $params;
    }

    function queryParamsInsert($data){
        $str = "";
        foreach($data as $key => $value){
            $str .= ":$key,";
        }
        $str = substr($str, 0, -1);
        return $str;
    }

    function removeIdField($fields){
        $fields = $this->fields;
        $f = array_diff($fields, ["id"]);
        $fields = implode(",", $f);

        return $fields;
    }
}
