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

class Views {

	public static function render($viewName = '') {
		global $oxws, $app;
		$viewPath = null;
		if (empty($viewName)) {
			$viewPath = 'index';
		} else {
			$lastLen = 0;
			foreach ($oxws['apps'][$app->getName()]['views']['files'] as $view) {
				$not = array('/index.php','index.php','.php');
				$normalized = str_replace($not, '', $view);
				if (strlen($normalized) > $lastLen && Utils::startsWith($normalized, $viewName)) {
					$url = (($app->getRequest() == '')?$viewName:$viewName.'/'.$app->getRequest());
					if (empty($oxws['apps'][$app->getName()]['contentName'])) {
						$tmp = $normalized;
					} else {
						$tmp = str_replace('/'.$oxws['apps'][$app->getName()]['contentName'], '', $normalized);
					}
					if (Utils::startsWith($url.'/', $tmp.'/')) {
						$lastLen = strlen($normalized);
						$viewPath = str_replace('.php', '', $view);
						$actionPath = substr($app->getRequest(), strlen($normalized.'/'));
					}
				}
			}
		}
		if ($viewPath != null) {
			$app->includeFile('views/'.$viewPath);
		}
	}

	public static function set($contentName) {
		global $oxws, $app;
		$oxws['apps'][$app->getName()]['contentName'] = $contentName;
	}

}

?>
