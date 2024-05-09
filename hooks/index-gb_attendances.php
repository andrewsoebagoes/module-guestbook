<?php

$having = "";
$where = "";

if(!empty($search))
{
    $_where = [];
    foreach([
        'gb_guests.name',
        'users.name',
        'gb_events.name'
    ] as $col)
    {
        $_where[] = "$col LIKE '%$search%'";
    }

    $where = "WHERE (".implode(' OR ',$_where).")";
}

if($filter)
{
    $filter_query = [];
    foreach($filter as $f_key => $f_value)
    {
        $filter_query[] = "$f_key = '$f_value'";
    }

    $filter_query = implode(' AND ', $filter_query);

    $having = (empty($having) ? 'HAVING ' : ' AND ') . $filter_query;
}

$where = $where ." ". $having;

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

$db->query = $query;
$data = $db->exec('all');

$db->query = "SELECT gb_attendances.id AS id,
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

$total = $db->exec('exists');

return compact('data', 'total');
