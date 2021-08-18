<?php
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
  <div id="top-wrapper">
    <header>
      <?php include(dirname(__FILE__)."/header_notlogin.php"); ?>
    </header>
    <div class="title">
      <h1>結末をみんなで考える小説投稿サイト</h1>
    </div>
    <div class="top-links">
      <button type="button" class="btn btn-success top-btn">
        <a href="topic_index.php" class="white">ログインせずに使用</a>
      </button>
      <button type="button" class="btn btn-success top-btn">
        <a href="register_form.php" class="white">新規登録はこちら</a>
      </button>
      <button type="button" class="btn btn-success top-btn">
        <a href="login_form.php" class="white">ログインはこちら</a>
      </button>
      <button type="button" class="btn btn-success top-btn">
        <a href="admin_register_form.php" class="white">管理者登録はこちら</a>
      </button>
      <button type="button" class="btn btn-success top-btn">
        <a href="admin_login_form.php" class="white">管理者はこちら</a>
      </button>
    </div>
  </div>
</body>
