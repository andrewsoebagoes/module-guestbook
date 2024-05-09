<?php

if(isset($_GET['event_id']) && $_GET['event_id'])
{
    $data['created_at'] = date('Y-m-d H:i:s');
}