<?php
// connect to the database
$db = new SQLite3('/data/todo.db');

// if this is a POST request
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  // if title and due are in the $_POST array
  if (array_key_exists('title', $_POST) && array_key_exists('due', $_POST)) {
    // inters a new todo item
    $insert = $db->prepare('INSERT INTO todoitems (title, due) VALUES (:title, :due)');
    $insert->bindParam(':title', $_POST['title'], SQLITE3_TEXT);
    $insert->bindParam(':due', $_POST['due'], SQLITE3_TEXT);
    $insert->execute();
    // redirect the page with a GET request
    header("Location: ");
  }
}

// get all the todo items ordered by due date
$result = $db->query('SELECT * FROM todoitems ORDER BY due');

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo list</title>
  </head>
  <body>
    <form method="POST">
      <label>Title<input type="text" name="title"/></label>
      <label>Due date<input type="date" name="due"/></label>
      <button>Create</button>
    </form>
    <ul>
      <?php while($item = $result->fetchArray()) { ?>
        <li><a href="item.php?id=<?php echo $item['id']; ?>"><?php echo $item['title']; ?> (<?php echo $item['due']; ?>)</a></li>
      <?php } ?>
    </ul>
    <p><a href="refresh.php">Refresh database</a></p>
  </body>
</html>