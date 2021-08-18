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

if (empty($_POST['secret_word'])) {
  $errormsg[] = '秘密の言葉の項目が空になっています。';
  $error += 1;
}

if ($error > 0) {
  $_SESSION['errormsg'] = $errormsg;
  $_SESSION['nameer'] = nl2br(htmlspecialchars($_POST['name'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
  $_SESSION['emailer'] = nl2br(htmlspecialchars($_POST['email'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
  $_SESSION['passworder'] = nl2br(htmlspecialchars($_POST['password'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
  $_SESSION['passwordconfirmer'] = nl2br(htmlspecialchars($_POST['password_confirm'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
  $_SESSION['secret_worder'] = nl2br(htmlspecialchars($_POST['secret_word'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
  header ("Location: ./register_form.php");
  exit();
} else {
  $register = new UserController;
  $register->userregi();
}
?>
