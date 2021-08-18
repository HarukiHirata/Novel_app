<?php
session_start();
require_once(ROOT_PATH .'Controllers/UserController.php');
$error = 0;
$errormsg = [];
if (mb_strlen($_POST['password']) < 8) {
  $errormsg[] = 'パスワードは8文字以上でお願いします。';
  $error += 1;
}

if (strcmp($_POST['password'], $_POST['password_confirm']) != 0) {
  $errormsg[] = 'パスワードとパスワード確認の内容が一致しません。';
  $error += 1;
}

if ($error > 0) {
  $_SESSION['errormsg'] = $errormsg;
  $_SESSION['nameer'] = $_POST['name'];
  $_SESSION['emailer'] = $_POST['email'];
  $_SESSION['passworder'] = $_POST['password'];
  $_SESSION['passwordconfirmer'] = $_POST['password_confirm'];
  $_SESSION['secret_worder'] = $_POST['secret_word'];
  header ("Location: ./passwordchange_form.php");
  exit();
} else {
  $pass = new UserController;
  $pass->passchange();
}
?>
