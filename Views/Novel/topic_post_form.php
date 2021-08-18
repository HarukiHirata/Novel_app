<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!isset($_SESSION['user_id'])) {
  header("Location: ./top.php");
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
      <?php include(dirname(__FILE__)."/header_login.php"); ?>
    </header>
    <div class="title">
      <h1>新規作品投稿</h1>
    </div>
    <div class="form-items">
      <form method="post" action="topic_post.php">
        <div class="form-group">
          <label>タイトル</label>
          <input type="text" class="form-control col-8" name="title">
        </div>
        <div class="form-group">
          <label>本文</label>
          <textarea name="body" class="form-control col-8" style="height: 50vh"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-info" name="not_release">下書き保存</button>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-info" name="release">投稿</button>
        </div>
        <div class="form-group">
          <input type="hidden" name="user_id" value="<?php if (isset($_SESSION['user_id'])) echo($_SESSION['user_id']); ?>">
        </div>
      </form>
    </div>
  </div>
</body>
