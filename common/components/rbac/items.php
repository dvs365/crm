<?php
return [
    'createClient' => [
        'type' => 2,
        'description' => 'Create a client',
    ],
    'updateClient' => [
        'type' => 2,
        'description' => 'Update client',
    ],
    'deleteClient' => [
        'type' => 2,
        'description' => 'Delete client',
    ],
    'manager' => [
        'type' => 1,
        'children' => [
            'createClient',
            'updateOwnClient',
            'deleteOwnClient',
        ],
    ],
    'moder' => [
        'type' => 1,
        'children' => [
            'updateClient',
            'deleteClient',
            'manager',
        ],
    ],
    'updateOwnClient' => [
        'type' => 2,
        'description' => 'Update own client',
        'ruleName' => 'isAuthor',
        'children' => [
            'updateClient',
        ],
    ],
    'deleteOwnClient' => [
        'type' => 2,
        'description' => 'Delete own client',
        'ruleName' => 'isAuthor',
        'children' => [
            'deleteClient',
        ],
    ],
];
