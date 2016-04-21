<?php
/**
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) Mindforce Team (http://mindforce.me)
* @link          http://mindforce.me FrontEngine CakePHP 3 Plugin
* @since         0.0.1
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/

use Cake\Event\EventManager;
use Cake\Core\Plugin;

Plugin::loadAll([
    ['ignoreMissing' => true, 'bootstrap' => true, 'routes' => true],
    'Garderobe/Bootstrap3',
    'RearEngine',
]);

EventManager::instance()->attach(
	new FrontEngine\Event\CoreEvent,
    null,
	['priority' => 2]
);
