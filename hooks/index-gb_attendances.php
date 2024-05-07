<?php

if ($filter) {
    $filter_query = [];
    foreach ($filter as $f_key => $f_value) {
        $filter_query[] = "$f_key = '$f_value'";
    }

    $filter_query = implode(' AND ', $filter_query);

    $where .= (empty($where) ? 'WHERE ' : ' AND ') . $filter_query;
}

$query = "SELECT gb_attendances.id AS id,
                     gb_guests.name AS guest_name,
                     gb_events.id AS event_id,
                     gb_attendances.created_at,
                     users.name AS user_name,
                     gb_events.name AS event_name
                FROM gb_attendances
                JOIN users ON gb_attendances.created_by = users.id
                JOIN gb_guests ON gb_attendances.guest_id = gb_guests.id
                JOIN gb_events ON gb_guests.event_id = gb_events.id
                $where ORDER BY " . $col_order . " " . $order[0]['dir'] . " LIMIT $start,$length";


$db->query = "SELECT COUN(*) FROM gb_attendances
JOIN users ON gb_attendances.created_by = users.id
JOIN gb_guests ON gb_attendances.guest_id = gb_guests.id
JOIN gb_events ON gb_guests.event_id = gb_events.id
$where ORDER BY " . $col_order . " " . $order[0]['dir'] . " LIMIT $start,$length";

$db->query = $query;
$data = $db->exec('all');
$total = $db->exec('exists');

return compact('data', 'total');
