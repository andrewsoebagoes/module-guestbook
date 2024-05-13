<?php

if(isset($_GET['event_id']) && $_GET['event_id'])
{
    $data['created_at'] = date('Y-m-d H:i:s');
    $guest = $data['guest_name'];
    $data['guest_id'] = $guest;
    $data['created_by'] = auth()->id;
    
}
unset($data['guest_name']);
