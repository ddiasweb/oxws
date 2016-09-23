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

class Database {

	static function query( $sql ) {
		global $app, $conn;
		if ( ! isset($conn) ) {
			$app->includeFile('config/db');
			if ( ! $conn = mysql_connect( DB_SERVER, DB_USERNAME, DB_PASSWORD ) ) {
				$error = "Database connection error";
				return $error;
			}
			if ( ! mysql_select_db( DB_NAME, $conn ) ) {
				$error = "Database not found";
				return $error;
			}
			if ( ! mysql_set_charset( 'utf8', $conn ) ) {
				$error = "Charset error";
				return $error;
			}
		}
		if ( ! $resource = mysql_query( $sql, $conn ) ) {
			$error = mysql_error();
			Data::set('error', $error);
			return $error;
		}
		$dl = Array();
		if (is_resource($resource)) {
			while( $row = mysql_fetch_assoc( $resource )) {
				$d = Array();
				foreach ( $row as $key => $value ) {
					if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/", $value)) {
						$date = date_create($value);
						if (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2} 00:00:00$/", $value)) {
							$d[$key] = date_format($date, 'd/m/Y');
						} else {
							$d[$key] = date_format($date, 'd/m/Y H:i:s');
						}
					} else {
						$d[$key] = $value;
					}
				}
				$dl[] = $d;
			}
		} else {
			$dl['id'] = mysql_insert_id( $conn );
		}
		return $dl;
	}

}

?>
