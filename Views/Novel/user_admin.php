<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/UserController.php');
$users = new UserController;
$params = $users->user_admin();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>結末をみんなで決める小説投稿サイト</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
  <div id="admin-wrapper">
    <header>
      <?php include(dirname(__FILE__)."/header_admin.php"); ?>
    </header>
    <div class="title">
      <h1>ユーザー一覧</h1>
    </div>
    <table class="table table-bordered" style="width: 70vw">
      <tr>
        <th>id</th>
        <th>名前</th>
        <th>メールアドレス</th>
        <th>削除</th>
      </tr>
      <?php foreach ($params['users'] as $user): ?>
        <tr>
          <td><?=$user['user_id'] ?></td>
          <td><?=$user['user_name'] ?></td>
          <td><?=$user['user_email'] ?></td>
          <td><a href="user_delete.php?id=<?php echo $user['user_id'] ?>" onclick="return confirm('削除してもよろしいですか')">削除</a></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
