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
use Oxsys\Oxws\Utils;
use Oxsys\Oxws\Helpers\Text;

class Oxws {

	static function initialize() {
		global $oxws;
		if (array_key_exists('PATH_INFO', $_SERVER)) {
			$oxws['request']['url'] = $_SERVER['PATH_INFO'];
		} else {
			$oxws['request']['url'] = $_SERVER['REQUEST_URI'];
		}
		$oxws['mapper']['apps'] = Mapper::getApps();
		$appPath = 'app';
		$appContext = $oxws['context'];
		foreach ($oxws['mapper']['apps'] as $app) {
			if (Utils::startsWith($oxws['request']['url'].'/', '/'.$app.'/')) {
				$appPath = 'app/' . $app;
				$appContext = $oxws['context'] . '/' . $app;
			}
		}
		$oxws['app'] = $appPath;
		$oxws['appContext'] = $appContext;
	}

	static function coalesce() {
		$args = func_get_args();
		foreach ($args as $arg) {
			if (!empty($arg)) {
				return $arg;
			}
		}
		return $args[0];
	}

	static function getModuleUrl($module=0 ){
		global $oxws;
		$modules = array_slice($oxws['request'], 0, $module+1);
		if ( $modules[0] == 'index' ) {
			array_shift( $modules );
		};
		return $oxws['context'].'/'.implode("/", $modules);
	}

	static function load($name) {
		global $app;
		$app->includeFile($name);
	}

	static function redirectTo($url='') {
		global $oxws;
		if (substr($oxws['request']['url'],1) != Oxws::getUrl($url)) {
			header('Location: '.Oxws::getUrl($url));
		}
	}

	static function getUrl ($url='') {
		global $oxws;
		return $oxws['context'].'/'.$url;
	}

	static function in($controller) {
		global $oxws;
		return substr($oxws['request']['url'],1) == $controller;
	}

	static function notIn($controller) {
		return !Oxws::in($controller);
	}

	static function getOxswVars ($url='') {
		global $oxws;
		return json_encode($oxws);
	}

}

?>
