<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>結末をみんなで決める小説投稿サイト</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/css/base.css">
</head>
<body>
  <div id="register-wrapper">
    <header>
      <?php include(dirname(__FILE__)."/header_notlogin.php"); ?>
    </header>
    <div class="title">
      <h1>管理者ログイン</h1>
    </div>
    <?php
    if (!empty($_SESSION['loginer'])) {
      echo $_SESSION['loginer'];
      echo "<br>";
    }
    ?>
    <div class="form-items">
      <form method="post" action="admin_login.php">
        <div class="form-group">
          <label>メールアドレス</label>
          <input type="text" class="form-control col-8" name="email">
        </div>
        <div class="form-group">
          <label>パスワード</label>
          <input type="password" class="form-control col-8" name="password">
        </div>
        <div class="form-group">
          <label>管理者番号</label>
          <input type="text" class="form-control col-8" name="admin_num">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-info">ログイン</button>
        </div>
      </form>
    </div>
  </div>
</body>

<?php
unset($_SESSION['loginer']);
?>
