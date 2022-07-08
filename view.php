<!doctype html>
<?php
if (isset($_GET['view'])) {
	$view = $_GET['view'];
} else {
	$view = "";
}

switch ($view) {
	case "register":
		include("register.php");
		break;
	case "room_del":
		include("room_del.php");
		break;
	case "room_edit":
		include("room_edit.php");
		break;
	case "room_create":
		include("room_create.php");
		break;
	case "room_list":
		include("room_list.php");
		break;
	case "logout":
		include("logout.php");
		break;
	default:
		include("login.php");
		break;
}
?>