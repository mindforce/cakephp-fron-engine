<?php
$config = [
    'App' => [
        'admin' => [
            'menu' => [
                'main' => [
                    'lookout' => [
                        'title' => __d('front_engine', 'Lookout'),
                        'weight' => 40,
                        'options' => [
                            'icon' => 'fa fa-leaf'
                        ],
                        'children' => [
                            'menus' => [
                                'title' => __d('front_engine', 'Menus'),
                                'url' => [
                                    'prefix' => 'admin',
                                    'plugin' => 'FrontEngine',
                                    'controller' => 'Menus',
                                    'action' => 'index'
                                ],
                                'weight' => 40,
                                'options' => [
                                    'icon' => 'fa fa-bars'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
