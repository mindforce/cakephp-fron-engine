<?php
/**
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) Mindforce Team (http://mindforce.me)
* @link          http://mindforce.me RearEngine CakePHP 3 Plugin
* @since         0.0.1
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/
namespace FrontEngine\Event;

use Cake\Event\EventListenerInterface;
use Cake\Core\Plugin;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Log\Log;

class CoreEvent implements EventListenerInterface {

    public function implementedEvents() {
        return array(
	        'Controller.initialize' => array(
                'callable' => 'onControllerInit',
		        'priority' => 1
            ),
            'View.beforeLayout' => [
                'callable' => 'setDefaultViewAssets'
            ]
        );
    }

    public function onControllerInit($event) {
        $controller = $event->getSubject();
        if(($theme = Configure::read('App.theme'))&&Plugin::loaded($theme)){
            $controller->viewBuilder()->theme($theme);
        }
    }

    public function setDefaultViewAssets($event){
        $view = $event->getSubject();
        $params = $view->request->params;
        if($meta = Configure::read('Meta')){
            $title = $view->fetch('title');
            if(isset($meta['title'])){
                $title = !empty($title) ? $title.' '.$meta['title_separator'].' '.$meta['title'] : $meta['title'];
            }
            $view->assign('title', $title);
            unset($meta['title']);
            unset($meta['title_separator']);
            foreach($meta as $key=>$value){
                if($view->fetch($key)){
                    $view->Html->meta($key, $view->fetch($key), ['block' => true]);
                } else {
                    $view->Html->meta($key, $value, ['block' => true]);
                }
            }
        }
    }

}
