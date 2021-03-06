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

class Data {

	private static $data = array();

	public static function set($key, $value) {
		Data::$data[$key] = $value;
	}

	public static function add($key, $value) {
		Data::$data[$key][] = $value;
	}

	public static function get($key, $default = null) {
		if (array_key_exists($key, Data::$data)) {
			return Data::$data[$key];
		} else {
			return $default;
		}
	}

	public static function load($key) {
		global $app;
		$dataPath = $app->getPath("data");
		$json = file_get_contents("$dataPath/$key.json");
		$data = json_decode($json, true);
		return $data;
	}

	public static function pull() {
		return Data::$data;
	}

}

?>
