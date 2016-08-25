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
 
namespace Oxsys\Oxws\Helpers;

use Oxsys\Oxws\Core;

class User {

	static function getName() {
		return array_key_exists('user', $_SESSION)?$_SESSION['user']['name']:'';
	}

	static function getLogin() {
		return array_key_exists('user', $_SESSION)?$_SESSION['user']['login']:'';
	}

	static function getId() {
		return array_key_exists('user', $_SESSION)?$_SESSION['user']['id']:'';
	}

	static function isLogged() {
		return isset($_SESSION['user']);
	}

	static function isNotLogged() {
		return !User::isLogged();
	}

	static function set($name = '', $login = '', $id = '') {
		if ($name) {
			$_SESSION['user'] = Array();
			$_SESSION['user']['login'] = $login;
			$_SESSION['user']['name'] = $name;
			$_SESSION['user']['id'] = $id;
		} else {
			unset($_SESSION['user']);
		}
	}

	static function setData($data) {
		$_SESSION['user']['data'] = $data;
	}

	static function getData($key = null) {
		if (array_key_exists('user', $_SESSION)) {
			if ($key == null) {
				return $_SESSION['user']['data'];
			} else {
				return array_key_exists($key, $_SESSION['user']['data'])?$_SESSION['user']['data'][$key]:'';
			}
		} else {
			return '';
		}
	}
}

?>
