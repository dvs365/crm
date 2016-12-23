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
    'user' => [
        'type' => 1,
        'children' => [
            'createClient',
        ],
    ],
    'moder' => [
        'type' => 1,
        'children' => [
            'updateClient',
            'user',
        ],
    ],
];
