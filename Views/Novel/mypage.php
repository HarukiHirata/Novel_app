<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/TopicController.php');
$topics = new TopicController;
$params_topuserid = $topics->findtopbyuserid();
$comments = new TopicController;
$params_comuserid = $comments->findcombyuserid();
$cotopics = new TopicController;
$cotopbyuserid = $cotopics->counttopbyuserid();
$cocomments = new TopicController;
$cocombyuserid = $cocomments->countcombyuserid();
$topfavo = new TopicController;
$params_topfavo = $topfavo->findtopfavo();
$comfavo = new TopicController;
$params_comfavo = $comfavo->findcomfavo();
$counttopfavobyuserid = 0;
$countcomfavobyuserid = 0;
$countfavobyuserid = 0;
foreach ($params_topfavo['topicfavorites'] as $topfavo) {
  if (isset($_SESSION['user_id']) && $topfavo['topics_userid'] == $_SESSION['user_id']) {
    $counttopfavobyuserid += 1;
    $countfavobyuserid += 1;
  }
}
foreach ($params_comfavo['commentfavorites'] as $comfavo) {
  if (isset($_SESSION['user_id']) && $comfavo['comments_userid'] == $_SESSION['user_id']) {
    $countcomfavobyuserid += 1;
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/css/base.css">
</head>
<body>
  <div id="topic-index-wrapper">
    <header>
      <?php include(dirname(__FILE__)."/header_login.php"); ?>
    </header>
    <div class="title">
      <h1><?php echo $_SESSION['name'] ?>さんのマイページ</h1>
    </div>
    <?php if ($countfavobyuserid >= 10): ?>
      <h2>称号：<span class="gold">ゴールド</span></h2>
    <?php elseif ($countfavobyuserid >= 5): ?>
      <h2>称号：<span class="silver">シルバー</span></h2>
    <?php else: ?>
      <h2>称号：<span class="blonze">ブロンズ</span></h2>
    <?php endif; ?>
    <table class="table table-bordered" style="width: 80vw">
      <colgroup>
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
      </colgroup>
      <tr>
        <th colspan="8"><?php echo $_SESSION['name'] ?>さんの作品一覧（非公開含む）</th>
      </tr>
      <tr>
        <td colspan="8">投稿した作品数：<?php echo $cotopbyuserid ?>件</td>
      </tr>
      <tr>
        <td colspan="8">投稿した作品へのいいね数：累計<?php echo $counttopfavobyuserid ?>件</td>
      </tr>
      <tr>
        <th colspan="3">タイトル</th>
        <th>いいね数</th>
        <th>公開状態</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <?php foreach ($params_topuserid['topics'] as $topic): ?>
        <?php
        $counttopfavobytopicid = 0;
        foreach ($params_topfavo['topicfavorites'] as $topfavo) {
          if ($topfavo['topic_id'] == $topic['topic_id']) {
            $counttopfavobytopicid += 1;
          }
        }
        ?>
        <tr>
          <td colspan="3"><?=$topic['title'] ?></td>
          <td><?php echo $counttopfavobytopicid ?>件</td>
          <?php if ($topic['open_flg'] == 0): ?>
            <td>非公開</td>
            <td>&nbsp;</td>
            <td><a href="topic_edit_form.php?id=<?php echo $topic['topic_id'] ?>">編集</a></td>
            <td><a href="topic_delete.php?id=<?php echo $topic['topic_id'] ?>">削除</a></td>
          <?php else: ?>
            <td>公開</td>
            <td><a href="topic_detail.php?id=<?php echo $topic['topic_id'] ?>">詳細</a></td>
            <td><a href="topic_edit_form.php?id=<?php echo $topic['topic_id'] ?>">編集</a></td>
            <td><a href="topic_delete.php?id=<?php echo $topic['topic_id'] ?>">削除</a></td>
          <?php endif; ?>
        </tr>
      <?php endforeach; ?>
    </table>
    <table class="table table-bordered" style="width: 80vw">
      <colgroup>
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
        <col style="width: 12.5%;">
      </colgroup>
      <tr>
        <th colspan="8"><?php echo $_SESSION['name'] ?>さんのコメント一覧</th>
      </tr>
      <tr>
        <td colspan="8">投稿したコメント数：<?php echo $cocombyuserid ?>件</td>
      </tr>
      <tr>
        <td colspan="8">投稿したコメントへのいいね数：累計<?php echo $countcomfavobyuserid ?>件</td>
      </tr>
      <tr>
        <th colspan="2">作品タイトル</th>
        <th colspan="3">本文</th>
        <th>いいね数</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
      <?php foreach ($params_comuserid['comments'] as $comment): ?>
        <?php
        $countcomfavobycommentid = 0;
        foreach ($params_comfavo['commentfavorites'] as $comfavo) {
          if ($comfavo['comment_id'] == $comment['comment_id']) {
            $countcomfavobycommentid += 1;
          }
        }
        ?>
        <tr>
          <td colspan="2"><?=$comment['title']?></td>
          <td colspan="3"><?=$comment['body'] ?></td>
          <td><?php echo $countcomfavobycommentid ?>件</td>
          <td><a href="comment_edit_form.php?id=<?php echo $comment['comment_id'] ?>">編集</a></td>
          <td><a href="comment_delete.php?id=<?php echo $comment['comment_id'] ?>">削除</a></td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>
