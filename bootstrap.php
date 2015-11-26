<?php
/*
* Copyright (C) 2015 Pearl Hackers <https://github.com/blackdesert>
*
* This program is free software; you can redistribute it and/or modify it
* under the terms of the GNU General Public License as published by the
* Free Software Foundation; either version 2 of the License, or (at your
* option) any later version.
*
* This program is distributed in the hope that it will be useful, but WITHOUT
* ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
* FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
* more details.
*
* You should have received a copy of the GNU General Public License along
* with this program. If not, see <http://www.gnu.org/licenses/>.
*/
require __DIR__.'/config.php';

$conn = @new mysqli('localhost', $config['database']['username'], $config['database']['password'], $config['database']['name']);

if ($conn->connect_error) {
	exit("Could not connect to MySQL database. Error code: ".$conn->connect_errno);
}

if (!(strnatcmp(phpversion(),'5.5.0') >= 0)) {
	exit("You need at least PHP 5.5 to run this application.");
}