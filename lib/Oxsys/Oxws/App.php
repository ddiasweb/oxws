<?php

/**
 *    Oxws <http://oxws.oxsys.com.br>
 *
 *    Copyright (C) 2016 Oxsys <http://oxsys.com.br/>
 *
 *    This file is part of Oxws.
 *
 *    Oxws is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    Foobar is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Oxws.  If not, see <http://www.gnu.org/licenses/>.
 *
 *    @link      https://github.com/ddiasweb/oxws
 *    @author    Décio Dias <ddiasweb@gmail.com>
 *    @copyright Copyright (C) 2016 Oxsys <http://oxsys.com.br/>
 *    @license   GPL-3.0 <https://github.com/ddiasweb/oxws/blob/master/LICENSE>
 */

namespace Oxsys\Oxws;

use Oxsys\Oxws\Mapper;
use Oxsys\Oxws\Controllers;
use Oxsys\Oxws\Data;

class App {

	private $name = null;
	private $path = null;
	private $request = null;

	function __construct($appName) {
		global $oxws;
		$this->name = $appName;
		$this->path = str_replace('/', '/apps/', $appName);
		$oxws['apps'][$this->name]['controllers'] = Mapper::getControllers($this->path);
		$oxws['apps'][$this->name]['views'] = Mapper::getViews($this->path);
	}

	function getName() {
		return $this->name;
	}

	function getPath($path) {
		global $oxws;
		$path = implode('/', array_filter(explode('/', $this->path.'/'.$path)));
		if (is_file("$path.php")) {
			return "$path.php";
		} else if (is_dir($path)) {
			return $path;
		} else {
			$oxws['alert']['getPath']['notFound'][] = $path;
		}
		return $this->path;
	}

	function execute($url) {
		global $oxws;
		$this->request = $this->name == 'app'?$url:str_replace('/'.$this->getUrlName(), '', $url);
		$oxws['apps'][$this->name]['request'] = $this->request;
		$this->processHooks('preControllers');
		Controllers::execute($this);
	}

	function includeFile($path) {
		global $oxws;
		$includeFile = $this->getPath($path);
		if ($includeFile != null) {
			if (is_file($includeFile)) {
				if (strpos($path, 'views') === 0) {
					extract(Data::pull());
				}
				$oxws['info']['includeFile']['included'][] = $includeFile;
				include_once($includeFile);
			} else {
				$oxws['alert']['includeFile']['notFound'][] = $includeFile;
			}
		}
	}

	function processHooks($hook) {
		$this->includeFile("hooks/$hook");
	}

	function getUrl() {
		global $oxws;
		$urlName = $this->getUrlName();
		if (empty($urlName)) {
			return $oxws['context'];
		}
		return $oxws['context'] . '/' . $this->getUrlName();
	}

	function getRequest() {
		return substr($this->request,1);
	}

	function getUrlName() {
		return substr($this->name,4);
	}

}

?>
