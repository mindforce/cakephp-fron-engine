<?php
namespace FrontEngine\Controller\Admin;

use FrontEngine\Controller\AppController;

/**
 * Menus Controller
 *
 * @property Menu $Menu
 */
class MenusController extends AppController {

	public function initialize()
	{
	    parent::initialize();
	    $this->loadComponent('RearEngine.Prg', [
	        'actions' => ['index' => 'Links']
	    ]);
	}

	public function index() {
		$this->loadModel('FrontEngine.Links');
		if($this->request->data('menu_id')){
			$links = $this->Links
		        // Use the plugins 'search' custom finder and pass in the
		        // processed query params
		        ->find('search', $this->Links->filterParams($this->request->query))
		        // You can add extra things to the query if you need to
		        ->contain(['Menus']);

			$this->set('links', $this->paginate($links));
		}
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function add() {
		$menu = $this->Menus->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->Menus->save($menu)) {
				$this->Flash->success('The menu has been saved.');
				return $this->redirect(['action' => 'index', '?' => ['menu_id' => $menu->id]]);
			} else {
				$this->Flash->error('The menu could not be saved. Please, try again.');
			}
		}
		$this->set(compact('menu'));
	}

	/**
	 * Edit method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException
	 */
	public function edit($id = null) {
		$menu = $this->Menus->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$menu = $this->Menus->patchEntity($menu, $this->request->data);
			if ($this->Menus->save($menu)) {
				$this->Flash->success('The menu has been saved.');
				return $this->redirect(['action' => 'index', '?' => ['menu_id' => $menu->id]]);
			} else {
				$this->Flash->error('The menu could not be saved. Please, try again.');
			}
		}
		$this->set(compact('menu'));
	}

	/**
	 * Delete method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException
	 */
	public function delete($id = null) {
		$menu = $this->Menus->get($id);
		$this->request->allowMethod('get', 'post', 'delete');
		if ($this->Menus->delete($menu)) {
			$this->Flash->success('The menu has been deleted.');
		} else {
			$this->Flash->error('The menu could not be deleted. Please, try again.');
		}
		return $this->redirect(['action' => 'index']);
	}

}
