<?php
namespace FrontEngine\Controller;

use Cake\Core\Configure;
use Cake\Routing\RequestActionTrait;
use FrontEngine\Controller\AppController;

class HomeController extends AppController
{

    use RequestActionTrait;

    public function index()
    {
        $page = '';
        if(!Configure::read('App.site.disable_homepage')){
            //currently basic info about platform if in menus homepage not setted up
            //TODO: implement default renderer from menus
            $url = ['plugin' => 'Platform', 'controller' => 'Basic', 'action' => 'info'];
            $page = $this->requestAction($url, ['return']);
        }
        $this->set(compact('page'));
    }

}
