<?php
/**
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) Mindforce Team (http://mindforce.me)
* @link          http://mindforce.me Platform CakePHP 3 Plugin
* @since         0.0.1
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/

$config = [
    [
        'path' => 'App.theme',
        'title' => 'Frontend theme',
	    'hidden' => true,
    ],
    [
        'path' => 'App.site.disable_homepage',
        'title' => 'Disable hompage output',
        'default' => 0,
        'options' => [
            "type" => "radio",
            "options" => [1 =>__('Yes'), 0 => __('No')]
        ],
    ],
    [
        'path' => 'Meta.title',
        'title' => 'Default site title',
        'default' => 'Front Engine',
    ],
    [
        'path' => 'Meta.title_separator',
        'title' => 'Title separator',
        'default' => '-',
    ],
    [
        'path' => 'Meta.generator',
        'title' => 'Meta generator',
        'default' => 'FrontEngine - helpful plugin for apps bakers',
    ],
    [
        'path' => 'Meta.robots',
        'title' => 'Robots directive',
        'default' => 'index, follow',
    ],
    [
        'path' => 'Meta.description',
        'title' => 'Meta description',
        'default' => 'My site for any people',
        'options' => [
            "type" => "textarea"
        ],
    ],
    [
        'path' => 'Meta.keywords',
        'title' => 'Meta keywords',
        'default' => 'FrontEngine, CakePHP admin, plugin',
		'options' => [
			"type" => "textarea"
		],
    ],
];
