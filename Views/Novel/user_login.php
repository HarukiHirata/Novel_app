<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/UserController.php');
$log_in = new UserController;
$log_in->log_in();
?>
