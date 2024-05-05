<?php return [
    [
        'label' => 'guestbook.menu.events',
        'icon'  => 'fa-fw fa-xl me-2 fa-solid fa-list-ul',
        'route' => routeTo('crud/index', ['table' => 'gb_events']),
        'activeState' => 'guestbook.events'
    ],
    [
        'label' => 'guestbook.menu.attendances',
        'icon'  => 'fa-fw fa-xl me-2 fa-solid fa-user-friends',
        'route' => routeTo('crud/index', ['table' => 'gb_attendances']),
        'activeState' => 'guestbook.attendances'
    ],
    [
        'label' => 'guestbook.menu.scan',
        'icon'  => 'fa-fw fa-xl me-2 fa-solid fa-search',
        'route' => routeTo('guestbook/scan'),
        'activeState' => 'guestbook.guests'
    ],
];