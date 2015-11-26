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
require __DIR__.'/bootstrap.php';

$response = [
	'error'		=> false,
	'errorMsg'	=> '',
	'data'		=> []
];
if (isset($_GET['cmd'])) {
	switch($_GET['cmd']) {
		case 'auth':
			$username = isset($_GET['username']) ? $conn->real_escape_string($_GET['username']) : '';
			$password = isset($_GET['password']) ? $conn->real_escape_string($_GET['password']) : '';

			if (!$username || !$password) {
				$response = [
					'error' 	=> true,
					'errorMsg' 	=> 'Invalid credentials.',
					'data'		=> []
				];
			} else {
				$result = $conn->query("SELECT * FROM users WHERE username='".$username."' 
					AND password='".md5($password)."'")->fetch_array(MYSQLI_ASSOC);

				if ($result) {
					$token = bin2hex(openssl_random_pseudo_bytes(96));
					$conn->query("UPDATE users SET login_token = '".$token."' WHERE id=".$result['id']);
					$response = [
						'data'		=> [
							'login_token'		=> $token,
						],
					];
				} else {
					$response = [
						'error' 	=> true,
						'errorMsg' 	=> 'Invalid credentials.',
						'data'		=> []
					];
				}
			}
		break;
		default:
			$response = [
				'error'		=> true,
				'errorMsg' 	=> 'Invalid command.',
				'data'		=> []
			];
		break;
	}
} else {
	$response = [
		'error'		=> true,
		'errorMsg'	=> 'Invalid parameters.',
		'data'		=> []
	];
}

header('Content-Type: application/json');
echo json_encode($response);