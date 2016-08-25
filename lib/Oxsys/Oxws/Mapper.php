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

use Oxsys\Oxws\Utils;
use Oxsys\Oxws\Helpers\Data;
use Oxsys\Oxws\Helpers\Text;

class Mapper {

	static function getApps() {
		global $oxws;
		$apps = array();
		$cPath = Utils::dirToArray('app');
		$cApps = Utils::getArrayInto($cPath, 'apps');
		$scan = Utils::plain($cApps);
		foreach ($scan as $path) {
			$apps[] = implode($path, '/');
		}
		return $apps;
	}

	static function getControllers($appPath) {
		global $oxws;
		$controllers = array();
		$cPath = Utils::dirToArray($appPath.'/controllers/');
		$scan = Utils::plain($cPath, true);
		foreach ($scan as $controller) {
			$controllers[] = implode($controller, '/');
		}
		return $controllers;
	}

	static function getViews($appPath) {
		global $oxws;
		$views = array();
		$cPath = Utils::dirToArray($appPath.'/views/');
		$scan = Utils::plain($cPath, true);
		foreach ($scan as $view) {
			$views['files'][] = implode($view, '/');
		}

		return $views;
	}

}

?>
