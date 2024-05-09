<?php

if(isset($_GET['event_id']) && isset($_GET['filter']['event_id']))
{
    unset($fields['event_id']);
    unset($fields['created_at']);
}

return $fields;