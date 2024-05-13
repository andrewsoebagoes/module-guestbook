<?php

if(is_allowed('crud/index?table=gb_attendances', auth()->id) && isset($_GET['filter']) && $_GET['filter']['event_id'])
{
    return '<a href="'.routeTo('guestbook/exportExcel',['filter'=>['event_id' => $_GET['filter']['event_id']]]).'" target="_blank" class="btn btn-primary btn-sm">
                <i class="fa-solid fa-upload"></i> Export Excel
            </a>'
            ;
}

return '';



