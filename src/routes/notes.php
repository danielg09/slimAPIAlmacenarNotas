<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//get all notes

$app->get('/api/notes', function (Request $request, Response $response) {
        
    $sql = "SELECT * from note";

    try{

        //get db

        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);

        $notes = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        echo json_encode($notes);



    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

//get single notes

$app->get('/api/note/{id}', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $sql = "SELECT * from note where id = $id";

    try{

        //get db

        $db = new db();
        //connect
        $db = $db->connect();

        $stmt = $db->query($sql);

        $note = $stmt->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        echo json_encode($note);

    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

// add notes

$app->post('/api/note/add', function (Request $request, Response $response) {
    
    $titulo = $request->getParam('titulo');
    $descripcion = $request->getParam('descripcion');
    
    $sql = "INSERT INTO note (titulo,descripcion) VALUES (:titulo,:descripcion)";


    
    try{
    
        //get db
    
        $db = new db();
        //connect
        $db = $db->connect();
    
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':titulo',$titulo);
        $stmt->bindParam(':descripcion',$descripcion);

        $stmt->execute();
        
    
        $db = null;

        echo '{"notice": {"text":"Nota agregada"}';
    
   
    } catch(PDOException $e){
    
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});

//update notes

$app->put('/api/note/update/{id}', function (Request $request, Response $response) {
    
    $id = $request->getAttribute('id');

    $titulo = $request->getParam('titulo');
    $descripcion = $request->getParam('descripcion');
    
    $sql = "UPDATE note SET titulo = :titulo, descripcion = :descripcion where id = $id";


    
    try{
    
        //get db
    
        $db = new db();
        //connect
        $db = $db->connect();
    
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam(':titulo',$titulo);
        $stmt->bindParam(':descripcion',$descripcion);

        $stmt->execute();
    
        $db = null;

        echo '{"notice": {"text":"Nota actualizada"}';
    
   
    } catch(PDOException $e){
    
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});

//delete single notes

$app->delete('/api/note/delete/{id}', function (Request $request, Response $response) {
    
    $id = $request->getAttribute('id');
    
    $sql = "DELETE from note where id = $id";
    
    try{
    
        //get db
    
        $db = new db();
        //connect
        $db = $db->connect();
    
        $stmt = $db->prepare($sql);
    
        $stmt->execute();
    
        $db = null;
    
        echo '{"notice": {"text":"Nota borrada"}';
    
    } catch(PDOException $e){
    
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
    });
    