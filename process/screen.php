<?php

use Core\Database;

$db = new Database;

$db->query = "SELECT * FROM gb_events";
$acara = $db->exec('all');


return view('guestbook/views/screen', compact('acara'));

?>