<?php
/*
GET    /categories      Get all the categories
*/

if (count($path) == 1) {
  // path /categories
  switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
      // requesting all categories
      $select = $conn->prepare('SELECT * FROM categories');
      if($select->execute()){
        $obj->categories = $select->fetchAll(PDO::FETCH_CLASS, 'Category');
        $obj->action = 'get all';
      }
      break;
  }
}

// note model
class Category
{
  public $id;
  public $title;
}

?>