<?php

use Core\Database;
use Core\Response;

$event_id = $_GET['id'];
$db = new Database;
$db->query = "SELECT gb_attendances.*, gb_guests.name FROM gb_attendances JOIN gb_guests ON gb_guests.id = gb_attendances.guest_id WHERE gb_attendances.screen_status = 'ON QUEUE' AND gb_guests.event_id = $event_id";
$screen = $db->exec('single');

if($screen)
{
    $db->update('gb_attendances', [
        'screen_status' => 'SHOW'
    ], [
        'id' => $screen->id
    ]);
}


return Response::json($screen, 'screen data retieved');