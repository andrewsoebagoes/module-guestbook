<?php 

return '
<a href="'.routeTo('guestbook/scan',['filter'=>['event_id' => $data->id]]).'" class="btn btn-sm btn-success"><i class="fas fa-search"></i> '.__('guestbook.label.scan').'</a> 
<a href="'.routeTo('guestbook/index-guests',['filter'=>['event_id' => $data->id]]).'" class="btn btn-sm btn-info"><i class="fas fa-users"></i> '.__('guestbook.label.guests').'</a> 
<a href="'.routeTo('crud/index', ['table' => 'gb_attendances', 'filter'=>['event_id' => $data->id]]).'" class="btn btn-sm btn-primary"><i class="fas fa-user-friends"></i> '.__('guestbook.label.attendance').'</a> 
';

?>