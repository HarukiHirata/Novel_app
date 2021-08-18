<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/TopicController.php');
$topic = new TopicController;
$params_det = $topic->topicdetail();
$topfavo = new TopicController;
$params_topfavo = $topfavo->findtopfavo();
$comfavo = new TopicController;
$params_comfavo = $comfavo->findcomfavo();
$counttopfavo = 0;
$checktopfavo = 0;
$countfavobyuserid = 0;

foreach ($params_topfavo['topicfavorites'] as $topfavorite) {
  if ($topfavorite['topic_id'] == $params_det['topic']['topic_id']) {
    $counttopfavo += 1;
  }
  if (isset($_SESSION['user_id']) && $topfavorite['topic_id'] == $params_det['topic']['topic_id'] && $topfavorite['topicfavorites_userid'] == $_SESSION['user_id']) {
    $checktopfavo += 1;
  }
  if ($params_det['topic']['user_id'] == $topfavorite['topics_userid']) {
    $countfavobyuserid += 1;
  }
}
foreach ($params_comfavo['commentfavorites'] as $comfavorite) {
  if ($params_det['topic']['user_id'] == $comfavorite['comments_userid']) {
    $countfavobyuserid += 1;
  }
}
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
  <div id="topic-detail-wrapper">
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
      <h1>投稿詳細</h1>
    </div>
    <table class="table table-bordered" style="width: 70vw">
      <colgroup>
        <col style="width: 33.3%;">
        <col style="width: 33.3%;">
        <col style="width: 33.3%;">
      </colgroup>
      <tr>
        <?php if ($countfavobyuserid >= 5): ?>
          <td>投稿者</td>
          <td colspan="2"><?=$params_det['topic']['user_name']; ?>（名人）</td>
        <?php else: ?>
          <td>投稿者</td>
          <td colspan="2"><?=$params_det['topic']['user_name']; ?> </td>
        <?php endif; ?>
      </tr>
      <tr>
        <td>タイトル</td>
        <td colspan="2"><?=$params_det['topic']['title']; ?></td>
      </tr>
      <tr>
        <td colspan="3">本文</td>
      </tr>
      <tr>
        <td colspan="3"><?=$params_det['topic']['body']; ?></td>
      </tr>
      <tr>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $params_det['topic']['user_id']): ?>
          <td><a href='topic_edit_form.php?id=<?php echo $params_det['topic']['topic_id']?>'>編集</a></td>
          <td><a href='topic_delete.php?id=<?php echo $params_det['topic']['topic_id']?>'>削除</a></td>
          <td>&nbsp;</td>
        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
          <td><a href='topic_edit_form.php?id=<?php echo $params_det['topic']['topic_id']?>'>編集</a></td>
          <td><a href='topic_delete.php?id=<?php echo $params_det['topic']['topic_id']?>'>削除</a></td>
          <td>&nbsp;</td>
        <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $params_det['topic']['user_id'] && $checktopfavo == 0): ?>
          <td colspan="3"><a href='topic_favorite.php?id=<?php echo $params_det['topic']['topic_id'] ?>'>いいね</a></td>
        <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $params_det['topic']['user_id'] && $checktopfavo != 0): ?>
          <td colspan="3"><a href='topic_unfavorite.php?id=<?php echo $params_det['topic']['topic_id'] ?>'>いいね解除</a></td>
        <?php endif; ?>
      </tr>
      <tr>
        <td colspan="3">いいね<?php echo $counttopfavo ?>件</td>
      </tr>
      <tr>
        <td colspan="3"><a href="comment_post_form.php?id=<?php echo $params_det['topic']['topic_id'] ?>">この作品の結末を考えて投稿！（その他コメントもこちら）</a></td>
      </tr>
      <tr>
        <td colspan="3"><a href="comment_index.php?id=<?php echo $params_det['topic']['topic_id'] ?>">みんなの考えた結末を見てみよう！</a></td>
      </tr>
    </table>
  </div>
</body>
