<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('Xml', 'Utility');


class LinksComponent extends Component {

	public function getPrototypes(){

		$searchdirs['App'] = APP.'View';
		$searchdirs['Basic'] = CakePlugin::path('Muffin');
		foreach(CakePlugin::loaded() as $plugin){
			if($plugin != 'Muffin'){
				$searchdirs[$plugin] = CakePlugin::path($plugin).'View';
			}
		}

		$configs = array();
		foreach ($searchdirs as $plugin=>$searchdir){
			$dir = new Folder($searchdir, false);
			if ($files = $dir->findRecursive('config.xml')){
				$configs = Hash::merge($configs, array($plugin => $files));
			}
		}
		$prototypes = array();
		foreach ($configs as $plugin=>$configFiles){
			$i = 0;
			foreach ($configFiles as $configFile){
				$xml =  Xml::build($configFile);
				$items = $xml->xpath('menu/item');

				if (!is_array($items)||empty($items)) continue;

				foreach ($items as $item){
					$item = Xml::toArray($item);
					if (empty($item['item']['@label'])) continue;
					if (!isset($item['item']['@id'])||empty($item['item']['@id'])){
						$id = ucfirst(Inflector::variable($item['item']['@label']));
					} else {
						$id = $item['item']['@id'];
					}

					$fields = array();
					foreach ($item['item']['field'] as $key=>$field){
						foreach($field as $name=>$value){
							$name = str_replace('@', '', $name);
							$fields[$key][$name] = $value;
						}
					}
					$prototypes[$plugin][$i]['Link']['id'] = $id;
					$prototypes[$plugin][$i]['Link']['priority'] = !empty($item['item']['@priority']) ? $item['item']['@priority'] : '10';
					$prototypes[$plugin][$i]['Link']['model'] = !empty($item['item']['@model']) ? $item['item']['@model'] : '';
					$prototypes[$plugin][$i]['Link']['label'] = $item['item']['@label'];
					$prototypes[$plugin][$i]['Field'] = $fields;
					$i++;
				}
			}
		}
		foreach ($prototypes as $plugin=>$section){
			$prototypes[$plugin] = Hash::sort($section, '{n}.Link.priority', 'asc');
		}
		return $prototypes;
	}

	public function canonicalUrl($url = array()){
		if(empty($url)) return '';

		if(is_string($url)) $url = Muffin::parseMetaUrl($url);

		foreach ($url as $name=>$value){
			if (($value === 'false')||($value === '0')){
				$url[$name] = false;
			}
		}

		return Router::url($url, true);

	}

	public function parseUrl($url = ''){
		if(empty($url)) return array();

		return Muffin::parseMetaUrl($url);;
	}

	public function buildUrl($url = array()){
		if (isset($url['admin'])) unset($url['admin']);

		return Muffin::buildMetaUrl($url);
	}

}