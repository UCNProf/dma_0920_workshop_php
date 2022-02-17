<?php
header('Location: /todo_result');

$db = new SQLite3('/data/todo.db');

$db->exec('DROP TABLE IF EXISTS todoitems');
$db->exec('CREATE TABLE todoitems (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, due TEXT)');
?>