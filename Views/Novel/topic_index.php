<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/TopicController.php');
$topics = new TopicController;
$params = $topics->alltopic();
$topfavo = new TopicController;
$params_topfavo = $topfavo->findtopfavo();
$comfavo = new TopicController;
$params_comfavo = $comfavo->findcomfavo();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>結末をみんなで決める小説投稿サイト</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
  <div id="topic-index-wrapper">
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
      <header>
        <?php include(dirname(__FILE__)."/header_login.php"); ?>
      </header>
    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
      <header>
        <?php include(dirname(__FILE__)."/header_admin.php"); ?>
      </header>
    <?php else: ?>
      <header>
        <?php include(dirname(__FILE__)."/header_notlogin.php"); ?>
      </header>
    <?php endif; ?>
    <div class="title">
      <h1>みんなの投稿</h1>
    </div>
    <table class="table table-bordered" style="width: 70vw">
      <colgroup>
        <col style="width: 20%;">
        <col style="width: 20%;">
        <col style="width: 20%;">
        <col style="width: 20%;">
        <col style="width: 20%;">
      </colgroup>
      <tr>
        <th>投稿者</th>
        <th>タイトル</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <?php foreach ($params['topics'] as $topic): ?>
        <?php
        $countfavobyuserid = 0;
        ?>
        <?php
        foreach ($params_topfavo['topicfavorites'] as $topfavorite) {
          if ($topfavorite['topics_userid'] == $topic['user_id']) {
            $countfavobyuserid += 1;
          }
        }
        foreach ($params_comfavo['commentfavorites'] as $comfavorite) {
          if ($comfavorite['comments_userid'] == $topic['user_id']) {
            $countfavobyuserid += 1;
          }
        }
        ?>
        <tr>
          <?php if ($countfavobyuserid >= 5): ?>
            <td><?=$topic['user_name'] ?>（名人）</td>
          <?php else: ?>
            <td><?=$topic['user_name'] ?> </td>
          <?php endif; ?>
          <td><?=$topic['title'] ?></td>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $topic['user_id']): ?>
            <td><a href="topic_detail.php?id=<?php echo $topic['topic_id'] ?>">詳細</td>
            <td><a href="topic_edit_form.php?id=<?php echo $topic['topic_id'] ?>">編集</td>
            <td><a href="topic_delete.php?id=<?php echo $topic['topic_id'] ?>" onclick="return confirm('削除してもよろしいですか。')">削除</td>
          <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
            <td><a href="topic_detail.php?id=<?php echo $topic['topic_id'] ?>">詳細</td>
            <td><a href="topic_edit_form.php?id=<?php echo $topic['topic_id'] ?>">編集</td>
            <td><a href="topic_delete.php?id=<?php echo $topic['topic_id'] ?>" onclick="return confirm('削除してもよろしいですか。')">削除</td>
          <?php else: ?>
            <td colspan="3"><a href="topic_detail.php?id=<?php echo $topic['topic_id'] ?>">詳細</td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
