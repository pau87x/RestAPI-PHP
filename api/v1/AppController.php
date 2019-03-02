<?php 

class AppController{
    public $model;

    public function __construct($model){
        $this->model = $model;
    }

    function parseJson($data){
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function getAll(){
        try{
            echo $this->parseJson($this->model->getAll());
        }catch(Exception $e){
            echo $this->parseJson(["error" => true, "message" => $e->getMessage()]);
        }
    }

    function findById(){
        try{
            echo $this->parseJson($this->model->getById($_GET['id']));
        }catch(Exception $e){
            echo $this->parseJson(["error" => true, "message" => $e->getMessage()]);
        }
    }

    function create(){
        $data = json_decode(file_get_contents('php://input'), true);

        $fields = array_diff($this->model->fields, ['id']);

        foreach($fields as $field){
            if(isset($data[$field])){
                $queryValues[$field] = $data[$field];
            }
        }

        try{
            echo $this->parseJson($this->model->insert($queryValues));
        }catch(Exception $e){
            echo $this->parseJson(["error" => true, "message" => $e->getMessage()]);
        }
    }

    function update(){
        $data = json_decode(file_get_contents('php://input'), true);

        $fields = array_diff($this->model->fields, ['id']);

        foreach($fields as $field){
            if(isset($data[$field])){
                $queryValues[$field] = $data[$field];
            }
        }

        if(isset($data['id'])){
            try{
                echo $this->parseJson($this->model->updateById($data['id'], $queryValues));
            }catch(Exception $e){
                echo $this->parseJson(["error" => true, "message" => $e->getMessage()]);
            }
        }else{
            echo $this->parseJson(["error" => true, "message" => "Bad Request: Id is not provided"]);
        }
    }

    function delete(){
        $data = json_decode(file_get_contents('php://input'), true);

        if(isset($data['id'])){
            try{
                echo $this->parseJson($this->model->deleteById($data['id']));
            }catch(Exception $e){
                echo $this->parseJson(["error" => true, "message" => $e->getMessage()]);
            }
        }else{
            echo $this->parseJson(["error" => true, "message" => "Bad Request: Id is not provided"]);
        }
    }

}