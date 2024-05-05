<?php 

return '<a href="'.routeTo('guestbook/index-guests',['filter'=>['event_id' => $data->id]]).'" class="btn btn-sm btn-info"><i class="fas fa-users"></i> '.__('guestbook.label.guests').'</a> ';

?>