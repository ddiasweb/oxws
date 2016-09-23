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

class Page {

	static $pages;

	static function getBreadcrumb($home = 'Home') {
		global $oxws, $app;
		$appUrl = $app->getUrl();
		$html = "<li><a href=\"$appUrl\">$home</a></li>";
		$path = explode('/', $oxws['request']['url']);
		array_shift($path);
		if (!empty($path) && $path[0] == substr($appUrl, 1)) {
			array_shift($path);
		}
		if (!empty($path)) {
			$url = $appUrl;
			foreach ($path as $page) {
				$url .= '/' . $page;
				if (!empty(Page::$pages)) {
					if (array_key_exists($page, Page::$pages)) {
						$title = Page::$pages[$page];
					} else if (array_key_exists($url, Page::$pages)) {
						$title = Page::$pages[$url];
					} else {
						$title = ucfirst($page);
					}
				} else {
					$title = ucfirst($page);
				}
				$pages[] = array('title' => $title, 'url' => $url);
			}

		}
		if (!empty($pages)) {
			$last = count($pages)-1;
			foreach ($pages as $key => $page) {
				$url = $page['url'];
				$title = $page['title'];
				if ($key == $last) {
					$html .= "<li>$title</li>";
				} else {
					$html .= "<li><a href=\"$url\">$title</a></li>";
				}
			}
		}
		return "<ul class=\"breadcrumb\">$html</ul>";
	}

	static function getTitle() {
		if (isset(Page::$pages)) {
			$page = end(Page::$pages);
			return $page;
		} else {
			return '';
		}
	}

	static function getId() {
		if (isset(Page::$pages)) {
			end(Page::$pages);
			$key = key(Page::$pages);
			return Utils::normalize($key);
		} else {
			return '';
		}
	}

	static function set($title, $url) {
		Page::$pages[$url] = $title;
	}

}

?>
