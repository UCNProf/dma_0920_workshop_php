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
      $update = $conn->prepare('UPDATE notes SET title = :title, content = :content, `date` = now() WHERE id = :id');
      $update->bindParam(':id', $id, PDO::PARAM_INT);
      $update->bindParam(':title', $request_data->title, PDO::PARAM_STR, 256);
      $update->bindParam(':content', $request_data->content, PDO::PARAM_STR);
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