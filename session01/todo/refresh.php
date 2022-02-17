<?php
// make this response do a redirect 
header('Location: /todo');

// connect to the database
$db = new SQLite3('/data/todo.db');

// remove the table todoitems from the database
$db->exec('DROP TABLE IF EXISTS todoitems');

// create the table todoitems
$db->exec('CREATE TABLE todoitems (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, due TEXT)');
?>