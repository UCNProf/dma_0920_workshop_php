<?php
// connect to the database
$db = new SQLite3('/data/todo.db');

// if this is a POST request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  // switch for different "actions": Create, Update, Delete
  switch ($_POST['action']) {
    
    case 'Create':
      // inters a new todo item
      $insert = $db->prepare('INSERT INTO todoitems (title, due) VALUES (:title, :due)');
      $insert->bindParam(':title', $_POST['title'], SQLITE3_TEXT);
      $insert->bindParam(':due', $_POST['due'], SQLITE3_TEXT);
      $insert->execute();

      // get last inserted id
      $last = $db->query('SELECT last_insert_rowid()');
      $id = $last->fetchArray()[0];
      
      // redirect to the page that now has an id
      header("Location: item.php?id=$id");
      break;
    
    case 'Update':
      // update a todo item
      $id = $_POST['id'];
      $update = $db->prepare('UPDATE todoitems SET title = :title, due = :due WHERE id = :id');
      $update->bindParam(':id', $id, SQLITE3_INTEGER);
      $update->bindParam(':title', $_POST['title'], SQLITE3_TEXT);
      $update->bindParam(':due', $_POST['due'], SQLITE3_TEXT);
      $update->execute();

      // redirect to the page that now has an id
      header("Location: item.php?id=$id");
      break;
    
    case 'Delete':
      // delete a todo item
      $delete = $db->prepare('DELETE FROM todoitems WHERE id = :id');
      $delete->bindParam(':id', $_POST['id'], SQLITE3_INTEGER);
      $delete->execute();
      
      // redirect to index
      header("Location: /todo_result/");
      break;
  }
}

$item = ['id' => '', 'title' => '', 'due' => ''];

if(array_key_exists('id', $_GET)){
  $select = $db->prepare('SELECT * FROM todoitems WHERE id = :id');
  $select->bindParam(':id', $_GET['id'], SQLITE3_INTEGER);
  $select_res = $select->execute();
  $item = $select_res->fetchArray(SQLITE3_ASSOC);
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo list item</title>
  </head>
  <body>
    <div><a href="/todo_result/">List</a></div>
    <form method="POST">
      <label>Title<input type="text" name="title" value="<?php echo $item['title']; ?>"/></label>
      <label>Due date<input type="date" name="due" value="<?php echo $item['due']; ?>"/></label>
      <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
      <input type="submit" name="action" value="<?php echo ($item['id'] != '') ? 'Update' : 'Create'; ?>"/>
    </form>
    <form method="POST">
      <input type="hidden" name="id" value="<?php echo $item['id']; ?>"/>
      <input type="submit" name="action" value="Delete"/>
    </form>
  </body>
</html>