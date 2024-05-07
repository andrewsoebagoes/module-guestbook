<?php

use Core\Database;
use Core\Response;


if($route == 'guestbook/screen-attendance') return true;

$auth = auth();
if(empty($auth))
{
    header('location:'.routeTo('auth/login'));
    die;
}

return true;