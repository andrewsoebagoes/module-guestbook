<?php

if(isset($_GET['filter']) && isset($_GET['filter']['event_id']))
{
    unset($fields['event_id']);
    $event_id = $_GET['filter']['event_id'];
    $fields['guest_name']['type'] .= '|event_id,'.$event_id;
}

unset($fields['created_at']);
unset($fields['created_by']);


return $fields;