<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/UserController.php');
$error = 0;
$errormsg = [];
if (empty($_POST['name'])) {
  $errormsg[] = '名前の項目が空になっています。';
  $error += 1;
}

if (empty($_POST['email'])) {
  $errormsg[] = 'メールアドレスの項目が空になっています。';
  $error += 1;
}

if (empty($_POST['password'])) {
  $errormsg[] = 'パスワードの項目が空になっています。';
  $error += 1;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $errormsg[] = 'メールアドレスの形式が間違っています。';
  $error += 1;
}

if (mb_strlen($_POST['password']) < 8) {
  $errormsg[] = 'パスワードは8文字以上でお願いいたします。';
  $error += 1;
}

if (strcmp($_POST['password'], $_POST['password_confirm']) != 0) {
  $errormsg[] = 'パスワードとパスワード確認の内容が一致しません。';
  $error += 1;
}

if (strcmp($_POST['admin_num'], '1234') != 0) {
  $errormsg[] = '管理者番号が間違っています。';
  $error += 1;
}

if ($error > 0) {
  $_SESSION['aderrormsg'] = $errormsg;
  $_SESSION['adnameer'] = $_POST['name'];
  $_SESSION['ademailer'] = $_POST['email'];
  $_SESSION['adpassworder'] = $_POST['password'];
  $_SESSION['adpasswordconfirmer'] = $_POST['password_confirm'];
  header ("Location: ./admin_register_form.php");
  exit();
} else {
  $adregister = new UserController;
  $adregister->adminregi();
}
?>
