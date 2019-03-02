<?php
    include('models/User.php');
    include('AppController.php');

    $controller = new AppController(new User());

    $method = $_SERVER['REQUEST_METHOD'];

    switch($method){
        case 'GET':
                if(!empty($_GET["id"])){
                    $id=intval($_GET["id"]);
                    $controller->findById();
                }
                else
                    $controller->getAll();
                break;
        case 'POST':
                $controller->create();
                break;
        case 'PUT':
                $controller->update();
                break;
        case 'DELETE':
                $controller->delete();
                break;
        default:
            echo json_encode(["error" => true, 
                                "message" => "Uknown HTTP method"],JSON_UNESCAPED_UNICODE);
            break;
    }