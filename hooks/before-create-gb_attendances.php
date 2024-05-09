<?php

$guest = $data['guest_name'];
$data['guest_id'] = $guest;
$data['created_by'] = auth()->id;

unset($data['guest_name']);