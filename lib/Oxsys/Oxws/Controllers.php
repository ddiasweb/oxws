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
use Oxsys\Oxws\Data;
use Oxsys\Oxws\Text;

class Controllers {

	public static function execute($app) {
		global $oxws;
		$actionPath = $app->getRequest();
		$controllerPath = 'index';
		$lastLen = 0;
		$controllers = $oxws['apps'][$app->getName()]['controllers'];
		if (empty($controllers)) {
			Data::add('error', '/app/controllers/index.php not found!');
		} else {
			foreach ($controllers as $controller) {
				$not = array('/index.php','index.php','.php');
				$normalized = str_replace($not, '', $controller);
				if (strlen($normalized) > $lastLen && Utils::startsWith($actionPath, $normalized)) {
					$lastLen = strlen($normalized);
					$controllerPath = str_replace('.php', '', $controller);
					$actionPath = substr($app->getRequest(), strlen($normalized.'/'));
				}
			}
		}
		$app->includeFile("controllers/$controllerPath");

		$oxws['info']['controller']['loaded'][] = $controllerPath;
		$className = Utils::last($controllerPath).'Controller';
		if (class_exists($className)) {
			$classLoaded = new $className($app);
			$parameters = array('index');
			if (!empty($actionPath)) {
				$parameters = array_reverse(explode('/', $actionPath));
				array_push($parameters, 'index');
			}
			Controllers::call($classLoaded, $parameters);
		} else {
			Data::add('error', 'class indexController not found!');
			Text::render();
		}
	}

	private static function call($classLoaded, $parameters) {
		$action = $parameters[0].'Action';
		if (method_exists($classLoaded, $action)) {
			array_shift($parameters);
			call_user_func_array(array($classLoaded, $action), $parameters);
		} else {
			if (!empty($parameters)) {
				array_push($parameters, array_shift($parameters));
				Controllers::call($classLoaded, $parameters);
			}
		}
	}

}

?>
