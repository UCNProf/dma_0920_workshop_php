<?php

/*
GET    /notes      Get all the notes
POST   /notes      Create a note
GET    /notes/[id] Get single note by id
PUT    /notes/[id] Update single note
DELETE /notes/[id] Delete single note
*/

if (count($path) > 1 && is_numeric($path[1])) {
  // path /notes/[id]
  $id = intval($path[1]);

  switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
      // get a single note
      $select = $conn->prepare('SELECT * FROM notes WHERE id = :id');
      $select->bindParam(':id', $id, PDO::PARAM_INT);
      if($select->execute()){
        $obj->note = $select->fetchObject('Note');
        $obj->action = 'get note';
      }
      break;
    case 'PUT':
      // update a single note
      $update = $conn->prepare('UPDATE notes SET title = :title, content = :content, category_id = :category_id, `date` = now() WHERE id = :id');
      $update->bindParam(':id', $id, PDO::PARAM_INT);
      $update->bindParam(':title', $request_data->title, PDO::PARAM_STR, 256);
      $update->bindParam(':content', $request_data->content, PDO::PARAM_STR);
      $cat_id = (is_numeric($request_data->category_id)) ? intval($request_data->category_id) : 1;
      $update->bindParam(':category_id', $cat_id, PDO::PARAM_INT);
      if($update->execute()){
        // get a single note
        $select = $conn->prepare('SELECT * FROM notes WHERE id = :id');
        $select->bindParam(':id', $id, PDO::PARAM_INT);
        if($select->execute()){
          $obj->note = $select->fetchObject('Note');
          $obj->action = 'update note';
        }  
      }
      break;
    case 'DELETE':
      // delete a single note
      $delete = $conn->prepare('DELETE FROM notes WHERE id=:id');
      $delete->bindParam(':id', $id, PDO::PARAM_INT);

      if($delete->execute()){
        $obj->id = $id;
        $obj->action = 'delete';
      }
      break;
  }
} elseif (count($path) == 1) {
  // path /notes
  switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
      // requesting all notes
      $select = $conn->prepare('SELECT * FROM notes');
      if($select->execute()){
        $obj->notes = $select->fetchAll(PDO::FETCH_CLASS, 'Note');
        $obj->action = 'get all';
      }
      break;
    case 'POST':
      // POST a new note
      $insert = $conn->prepare('INSERT INTO notes (title, content, category_id, date, user_id) VALUES (:title, :content, :category_id, now(), 1)');
        $insert->bindParam(':title', $request_data->title, PDO::PARAM_STR, 256);
        $insert->bindParam(':content', $request_data->content, PDO::PARAM_STR);
        $cat_id = (is_numeric($request_data->category_id)) ? intval($request_data->category_id) : 1;
        $insert->bindParam(':category_id', $cat_id, PDO::PARAM_INT);
        if($insert->execute()){
          // get a single note by lastInsertedId
          $id = $conn->lastInsertId();
          $select = $conn->prepare('SELECT * FROM notes WHERE id = :id');
          $select->bindParam(":id", $id, PDO::PARAM_INT);
          if($select->execute()){
            $obj->note = $select->fetchObject('Note');
            $obj->action = 'update note';
          }
        } 
      break;
  }
}

// note model
class Note
{
  public $id;
  public $title;
  public $content;
  public $date;
}
?>