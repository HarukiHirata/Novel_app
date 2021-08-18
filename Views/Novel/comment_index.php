<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/TopicController.php');
$comments = new TopicController;
$params_com = $comments->findcom();
$topic = new TopicController;
$params_det = $topic->topicdetail();
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
      <h1>「<?php echo $params_det['topic']['title'] ?>」に寄せられたコメント一覧</h1>
    </div>
    <table class="table table-bordered" style="width: 70vw">
      <colgroup>
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
      </colgroup>
      <tr>
        <td colspan="10"><a href="comment_post_form.php?id=<?php echo $params_det['topic']['topic_id'] ?>">この作品の結末を考えて投稿！（その他コメントもこちら）</a></td>
      </tr>
      <tr>
        <th colspan="10">みんなの考えた結末</th>
      </tr>
      <tr>
        <th colspan="2">投稿者</th>
        <th colspan="4">内容</th>
        <th colspan="4">&nbsp;</th>
      </tr>
      <?php foreach ($params_com['comments'] as $comment): ?>
        <?php
        $countcomfavo = 0;
        $checkcomfavo = 0;
        $countfavobyuserid = 0;
        foreach ($params_comfavo['commentfavorites'] as $comfavo) {
          if ($comfavo['comment_id'] == $comment['comment_id']) {
            $countcomfavo += 1;
          }
          if (isset($_SESSION['user_id']) && $comfavo['comment_id'] == $comment['comment_id'] && $comfavo['commentfavorites_userid'] == $_SESSION['user_id']) {
            $checkcomfavo += 1;
          }
          if ($comfavo['comments_userid'] == $comment['user_id']) {
            $countfavobyuserid += 1;
          }
        }
        foreach ($params_topfavo['topicfavorites'] as $topfavo) {
          if ($topfavo['topics_userid'] == $comment['user_id']) {
            $countfavobyuserid += 1;
          }
        }
        ?>
        <tr>
          <?php if ($comment['category'] == '結末'): ?>
            <?php if ($countfavobyuserid >= 5): ?>
              <td colspan="2"><?=$comment['user_name'] ?> （名人）</td>
            <?php else: ?>
              <td colspan="2"><?=$comment['user_name'] ?> </td>
            <?php endif; ?>
            <td colspan="4"><?=$comment['body'] ?></td>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
              <td><a href="comment_edit_form.php?id=<?php echo $comment['comment_id'] ?>">編集</a></td>
              <td><a href="comment_delete.php?id=<?php echo $comment['comment_id'] ?>" onclick="return confirm('削除してもよろしいですか')">削除</a></td>
              <td colspan="2">いいね<?php echo $countcomfavo ?>件</td>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
              <td><a href="comment_edit_form.php?id=<?php echo $comment['comment_id'] ?>">編集</a></td>
              <td><a href="comment_delete.php?id=<?php echo $comment['comment_id'] ?>" onclick="return confirm('削除してもよろしいですか')">削除</a></td>
              <td colspan="2">いいね<?php echo $countcomfavo ?>件</td>
            <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $comment['user_id']): ?>
              <?php if ($checkcomfavo == 0): ?>
                <td colspan="2"><a href="comment_favorite.php?id=<?php echo $comment['comment_id'] ?>">いいね</a></td>
              <?php else: ?>
                <td colspan="2"><a href="comment_unfavorite.php?id=<?php echo $comment['comment_id'] ?>">いいね解除</a></td>
              <?php endif; ?>
              <td colspan="2">いいね<?php echo $countcomfavo ?>件</td>
            <?php else: ?>
              <td colspan="4">いいね<?php echo $countcomfavo ?>件</td>
            <?php endif; ?>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
      <tr>
        <th colspan="10">その他のコメント</th>
      </tr>
      <tr>
        <th colspan="2">投稿者</th>
        <th colspan="4">内容</th>
        <th colspan="4">&nbsp;</th>
      </tr>
      <?php foreach ($params_com['comments'] as $comment): ?>
        <?php
        $countcomfavo = 0;
        $checkcomfavo = 0;
        $countfavobyuserid = 0;
        foreach ($params_comfavo['commentfavorites'] as $comfavo) {
          if ($comfavo['comment_id'] == $comment['comment_id']) {
            $countcomfavo += 1;
          }
          if (isset($_SESSION['user_id']) && $comfavo['comment_id'] == $comment['comment_id'] && $comfavo['commentfavorites_userid'] == $_SESSION['user_id']) {
            $checkcomfavo += 1;
          }
          if ($comfavo['comments_userid'] == $comment['user_id']) {
            $countfavobyuserid += 1;
          }
        }
        foreach ($params_topfavo['topicfavorites'] as $topfavo) {
          if ($topfavo['topics_userid'] == $comment['user_id']) {
            $countfavobyuserid += 1;
          }
        }
        ?>
        <tr>
          <?php if ($comment['category'] == 'その他'): ?>
            <?php if ($countfavobyuserid >= 5): ?>
              <td colspan="2"><?=$comment['user_name'] ?> （名人）</td>
            <?php else: ?>
              <td colspan="2"><?=$comment['user_name'] ?> </td>
            <?php endif; ?>
            <td colspan="4"><?=$comment['body'] ?></td>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $comment['user_id']): ?>
              <td><a href="comment_edit_form.php?id=<?php echo $comment['comment_id'] ?>">編集</a></td>
              <td><a href="comment_delete.php?id=<?php echo $comment['comment_id'] ?>" onclick="return confirm('削除してもよろしいですか')">削除</a></td>
              <td colspan="2">いいね<?php echo $countcomfavo ?>件</td>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
              <td><a href="comment_edit_form.php?id=<?php echo $comment['comment_id'] ?>">編集</a></td>
              <td><a href="comment_delete.php?id=<?php echo $comment['comment_id'] ?>" onclick="return confirm('削除してもよろしいですか')">削除</a></td>
              <td colspan="2">いいね<?php echo $countcomfavo ?>件</td>
            <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $comment['user_id']): ?>
              <?php if ($checkcomfavo == 0): ?>
                <td colspan="2"><a href="comment_favorite.php?id=<?php echo $comment['comment_id'] ?>">いいね</a></td>
              <?php else: ?>
                <td colspan="2"><a href="comment_unfavorite.php?id=<?php echo $comment['comment_id'] ?>">いいね解除</a></td>
              <?php endif; ?>
              <td colspan="2">いいね<?php echo $countcomfavo ?>件</td>
            <?php else: ?>
              <td colspan="4">いいね<?php echo $countcomfavo ?>件</td>
            <?php endif; ?>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
