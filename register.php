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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$errors = [];

	$username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
	$password = isset($_POST['password']) ? $conn->real_escape_string($_POST['password']) : '';

	if (!$username || !$password) {
		$errors[] = 'Please specify username and password.';
	} else if ($conn->query("SELECT id FROM users WHERE username='".$username."'")->num_rows > 0){
		$errors[] = 'Player with this name already exists.';
	} else {
		$conn->query("INSERT INTO users (username, password, login_token) VALUES ('".$username."', '".md5($password)."', '')");
		$registered = TRUE;
	}
}
?>
<!DOCTYPE>
<html>
<head>
	<title>Black Desert - Create new account</title>
</head>
<body>
	<div style="text-align:center">
		<?php
		if (isset($registered)) {
		?>
			Your account has been registered. You may now use the launcher to login.
		<?php
		} else {
			if (isset($errors) && count($errors) > 0) {
				echo "<ul>";
				foreach($errors as $error) {
					echo "<li>".$error."</li>";
				}
				echo "</ul>";
			}
			?>
			<form action="" method="POST">
				Username: <input name="username"/><br/>
				Password: <input name="password"/><br/>
				<br/>
				<input type="submit" value="Create">
			</form>
		<?php
		}
		?>
	</div>
</body>
</html>