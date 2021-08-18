<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/UserController.php');
if (strcmp($_POST['admin_num'], '1234') != 0) {
  $_SESSION['loginer'] = 'ログインに失敗しました。';
  header("Location: ./admin_login_form.php");
  exit();
} else {
  $admin = new UserController;
  $admin->adlogin();
}
?>
