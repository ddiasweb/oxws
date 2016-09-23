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

use Oxsys\Oxws\Data;

class Utils {

	static function startsWith($haystack, $needle)	{
		return strpos($haystack, $needle) === 0;
	}

	static function endsWith($haystack, $needle) {
		return substr($haystack, -strlen($needle)) == $needle;
	}

	static function dirToArray($dir, $files = true) {
		$result = array();
		$dirPath = BASE_PATH . DIRECTORY_SEPARATOR . $dir;
		if (!is_dir($dirPath)) {
			Data::add('error', "/$dir not found!");
			return $result;
		}
		$cdir = scandir($dirPath);
		$not = array('.','..');
		foreach ($cdir as $key => $value) {
			if (!in_array($value, $not)) {
				if (is_dir($dirPath . DIRECTORY_SEPARATOR . $value)) {
					if (is_executable($dir . DIRECTORY_SEPARATOR . $value)) {
						$result[$value] = Utils::dirToArray($dir . DIRECTORY_SEPARATOR . $value, $files);
					}
				} else {
					if ($files) {
						$result[] = $value;
					}
				}
			}
		}
		return $result;
	}

	static function getArrayInto($arr, $into = null, $pk = null) {
		$tmp = array();
		foreach ($arr as $key => $value) {
			if (is_array($value)) {
				if ($into == $pk) {
					$tmp[$key] = Utils::getArrayInto($value, $into, $key);
				} else {
					$tmp = array_merge($tmp, Utils::getArrayInto($value, $into, $key));
				}
			}
		}
		return $tmp;
	}

	static function plain($arr, $prune = false, $k = array()) {
		$tmp = array();
		foreach ($arr as $key => $value) {
			$push = $k;
			if (is_array($value)) {
				array_push($push, $key);
				if (!$prune) {
					$tmp[] = $push;
				}
				$tmp = array_merge($tmp, Utils::plain($value, $prune, $push));
			} else {
				array_push($push, $value);
				$tmp[] = $push;
			}
		}
		return $tmp;
	}


	static function last($string) {
		$arr = explode('/', $string);
		return $arr[count($arr)-1];
	}

	static function normalize ($string){
	    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	    $string = utf8_decode($string);
	    $string = strtr($string, utf8_decode($a), $b);
	    $string = strtolower($string);
	    return utf8_encode($string);
	}

}

?>
