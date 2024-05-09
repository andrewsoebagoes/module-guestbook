<?php

use Core\Database;

$id = $_GET['id'];
$db = new Database;
$db->query = "SELECT gb_attendances.* FROM gb_attendances JOIN gb_guests ON gb_guests.id = gb_attendances.guest_id WHERE gb_attendances.id = $id";
$attendance = $db->exec('single');
$db->update('gb_attendances', ['status' => 'ON QUEUE'], ['id'=>$id]);
set_flash_msg(['success' => "Sukses menampilkan ke screen"]);

header('location:'.routeTo('crud/index', ['table'=>'gb_attendances','filter' => ['event_id' => $attendance->event_id]]));
die;
