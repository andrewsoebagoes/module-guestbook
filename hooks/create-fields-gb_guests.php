<?php

if(isset($_GET['event_id']) && isset($_GET['event_id']))
{
    unset($fields['event_id']);
}

return $fields;