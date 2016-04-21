<?php
namespace FrontEngine\Controller\Admin;

use FrontEngine\Controller\AppController;

/**
 * Links Controller
 *
 * @property Link $Link
 */
class LinksController extends AppController {

	public function initialize()
	{
	    parent::initialize();
		//$this->loadModel('FrontEngine.Menus');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	/*
	public function admin_index() {
		$menu_title = '';

		if ($menu_id = $this->Filter->readParam('Link.menu_id')){
			$menu = $this->Link->Menu->find('first', array(
				'conditions' => array('id'=>$menu_id)
			));
			$menu_title = $menu['Menu']['title'];
		}

		$linksTree = $links = array();


		if (!empty($menu_id)){
			$this->Link->recursive = 0;

			$linksTree = $this->Link->generateTreeList(array(
				'Link.menu_id' => $menu_id,
			), null, null, '|--&nbsp;');

			$this->Paginator->settings = array(
				'conditions' => array(
					'Link.menu_id' => $menu_id,
				),
				'order' => array(
					'Link.lft' => 'ASC',
				),
				'fields' => array(
					'Link.id',
					'Link.title',
					'Link.link',
					'Link.homepage',
					'Link.state',
				),
				'limit' => 999999
			);
			$links = $this->Paginator->paginate();
		}

		$this->set('title_for_layout', __d('muffin', 'Links: %s', $menu_title));
		$this->set(compact('linksTree', 'links', 'menu'));
	}
	*/

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add($menuId = null) {
		$link = $this->Links->newEntity($this->request->data);
		$this->Links->behaviors()->Tree->config('scope', ['menu_id' => $menuId]);
		if ($this->request->is('post')) {
			if ($this->Links->save($link)) {
				$this->Flash->success('The link has been saved.');
				return $this->redirect(['action' => 'index', '?' => ['menu_id' => $link->menu_id]]);
			} else {
				$this->Flash->error('The link could not be saved. Please, try again.');
			}
		}
		$menus = $this->Links->Menus->find('list');
		$links = $this->Links->find('treeList', [
		    'keyPath' => 'title',
		    'valuePath' => 'id',
		    'spacer' => '-'
		]);
		$this->set(compact('link', 'menus', 'links'));
	}

	/**
	 * admin_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null) {
		$link = $this->Links->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$link = $this->Links->patchEntity($link, $this->request->data);
			if ($this->Links->save($link)) {
				$this->Flash->success('The link has been saved.');
				return $this->redirect(['action' => 'index', '?' => ['menu_id' => $link->menu_id]]);
			} else {
				$this->Flash->error('The link could not be saved. Please, try again.');
			}
		}
		$menus = $this->Links->Menus->find('list');
		$links = $this->Links->find('treeList', [
		    'keyPath' => 'title',
		    'valuePath' => 'id',
		    'spacer' => '-'
		]);
		$this->set(compact('link', 'menus', 'links'));
	}

	/**
	 * Delete method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException
	 */
	public function delete($id = null) {
		$link = $this->Links->get($id);
		$this->request->allowMethod('get', 'post', 'delete');
		if ($this->Links->delete($link)) {
			$this->Flash->success('The link has been deleted.');
		} else {
			$this->Flash->error('The link could not be deleted. Please, try again.');
		}
		return $this->redirect(['action' => 'index', '?' => ['menu_id' => $link->menu_id]]);
	}


	/* Old cake 2 tricks */
	/**
	 * Admin moveup
	 *
	 * @param integer $id
	 * @param integer $step
	 * @return void
	 * @access public
	 */
	public function admin_moveup($id, $step = 1) {
		$link = $this->Link->findById($id);
		if (!isset($link['Link']['id'])) {
			$this->Session->setFlash(__d('muffin', 'Invalid id for Link'), 'alert', array('class' => 'alert-error'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Link->Behaviors->attach('Tree', array(
			'scope' => array(
				'Link.menu_id' => $link['Link']['menu_id'],
			),
		));
		if ($this->Link->moveUp($id, $step)) {
			$this->Session->setFlash(__d('muffin', 'Moved up successfully'), 'alert', array('class' => 'alert-success'));
		} else {
			$this->Session->setFlash(__d('muffin', 'Could not move up'), 'alert', array('class' => 'alert-error'));
		}
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * Admin movedown
	 *
	 * @param integer $id
	 * @param integer $step
	 * @return void
	 * @access public
	 */
	public function admin_movedown($id, $step = 1) {
		$link = $this->Link->findById($id);
		if (!isset($link['Link']['id'])) {
			$this->Session->setFlash(__d('muffin', 'Invalid id for Link'), 'alert', array('class' => 'alert-error'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Link->Behaviors->attach('Tree', array(
			'scope' => array(
				'Link.menu_id' => $link['Link']['menu_id'],
			),
		));
		if ($this->Link->moveDown($id, $step)) {
			$this->Session->setFlash(__d('muffin', 'Moved down successfully'), 'alert', array('class' => 'alert-success'));
		} else {
			$this->Session->setFlash(__d('muffin', 'Could not move down'), 'alert', array('class' => 'alert-error'));
		}
		$this->redirect(array('action' => 'index'));
	}

	public function admin_get_list() {

		$menu_id = Set::classicExtract($this->request->data, "{s}.menu_id");

		$options = array();
		if (!empty($menu_id)){
			$options = array('menu_id' => $menu_id);
		}
		$links = $this->Link->generateTreeList($options, null, null, '|-- ');

		if (empty($links)) {
			$links = array('0' => '');
		} else {
			$links = array('0' => '') + $links;
		}

		$this->set(compact('links'));
	}

	public function admin_available_links($id = null) {

		if (!empty($id)){
			$this->set('link', $this->Link->findById($id));
		}
		$prototypes = $this->Links->getPrototypes();

		$this->set(compact('prototypes'));

	}

	public function admin_change_link() {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		if (isset($this->request->data['Link']['custom_url'])
			&&!empty($this->request->data['Link']['custom_url'])){
			$metaUrl = $this->request->data['Link']['custom_url'];
			$canonicalUrl = Router::url($this->request->data['Link']['custom_url'], true);
		} else {
			if (!isset($this->request->data['Link']['prototype_id'])
				||empty($this->request->data['Link']['prototype_id'])) {
				throw new NotFoundException(__d('muffin', 'Invalid %s', __d('muffin', 'link')));
			}
			$link_id = $this->request->data['Link']['prototype_id'];
			$metaUrl = $this->Links->buildUrl($this->request->data['Link'][$link_id]);
			$canonicalUrl = $this->Links->canonicalUrl($this->request->data['Link'][$link_id]);
		}

		$response = array(
			'code' => 200,
			'link' => $metaUrl,
			'linkView' => $canonicalUrl,
			'message' => __d('muffin', 'Link successfully changed'),
		);
		//plugin:content/controller:articles/action:view/category:null/id:10/slug:obo-mne
		if (isset($this->request->data['Link']['id'])&&!empty($this->request->data['Link']['id'])){
			$this->Link->id = $this->request->data['Link']['id'];
			if (!$this->Link->saveField('link', $metaUrl)){
				$response = array(
					'code' => 500,
					'message' => __d('muffin', 'There was error in changes process'),
				);
			}
		}

		echo json_encode($response);
		exit();

	}

	private function reset_menu($menu_id = null){
		if(!empty($menu_id)){
			$menus = array($menu_id => $menu_id);
		} else {
			$menus = $this->Link->Menu->find('list', array(
				'fields' => array('Menu.id'),
				'conditions' => array('Menu.link_count >' => 0)
			));
		}
		foreach($menus as $menu_id){
			$this->Link->Behaviors->unload('Tree');
			$this->Link->Behaviors->load('Tree', array(
				'scope' => array(
					'Link.menu_id' => $menu_id,
				),
			));
			$this->Link->recover('parent');

			/*
			$this->Link->reorder(array(
			    'id' => null,
			    'field' => $this->Link->displayField,
			    'order' => 'ASC',
			    'verify' => true
			));
			*/
		}
	}

	/*
	 * Admin reset. Recover widget tree for all blocks
	*/
	public function admin_reset(){
		$this->reset_menu();
		$this->redirect(array('action' => 'index'));
	}
}
