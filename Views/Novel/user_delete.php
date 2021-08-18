<?php
require_once(ROOT_PATH .'Controllers/UserController.php');
$user = new UserController();
$delete = $user->userdelete();
header("Location: ./user_admin.php");
exit();
?>
