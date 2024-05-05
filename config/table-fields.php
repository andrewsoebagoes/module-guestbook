<?php return [

    'gb_events' => [
        'name' => [
            'label' => __('guestbook.label.name'),
            'type' => 'text'
        ],
        'start_at' => [
            'label' => __('guestbook.label.start'),
            'type'  => 'datetime-local'
        ],
        'end_at' => [
            'label' => __('guestbook.label.end'),
            'type'  => 'datetime-local'
        ],
    ],

    'gb_guests' => [
        'event_id' => [
            'label' => __('guestbook.label.event_id'),
            'type' => 'options-obj:gb_events,id,name'
        ],
        'name' => [
            'label' => __('guestbook.label.name'),
            'type' => 'text'
        ],
        'graduation_year' => [
            'label' => __('guestbook.label.graduation_year'),
            'type' => 'text'
        ],
        'registration_date' => [
            'label' => __('guestbook.label.registration_date'),
            'type' => 'date'
        ],
        'seat_number' => [
            'label' => __('guestbook.label.seat_number'),
            'type' => 'number'
        ],
        'qrcode_value' => [
            'label' => __('guestbook.label.qrcode_value'),
            'type' => 'text'
        ],
    ],
    'gb_attendances' => [
        'guest_id' => [
            'label' => __('guestbook.label.guest'),
            'type' => 'options-obj:gb_guests,id,name'
        ],
        'created_by' => [
            'label' => __('guestbook.label.created_by'),
            'type' => 'options-obj:users,id,name'
        ],
        'created_at' => [
            'label' => __('guestbook.label.created_at'),
            'type' => 'text'
        ],
    ]


];
