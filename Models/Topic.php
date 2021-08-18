<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Models/Db.php');

class Topic extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  public function topost() {
    if (isset($_POST['not_release'])) {
      $open = 0;
    } elseif (isset($_POST['release'])) {
      $open = 1;
    }
    $title = nl2br(htmlspecialchars($_POST['title'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $body = nl2br(htmlspecialchars($_POST['body'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $sql = 'INSERT INTO topics SET title="'.$title.'",user_id="'.$_POST['user_id'].'",body="'.$body.'",del_flg=0,open_flg="'.$open.'";';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    header("Location: ./topic_index.php");
    exit();
  }

  public function findTopic() {
    $sql = 'SELECT topics.id AS topic_id, users.name AS user_name, topics.user_id AS user_id, topics.title AS title, topics.body AS body FROM topics';
    $sql .= ' INNER JOIN users ON topics.user_id = users.id WHERE topics.open_flg = 1 AND topics.del_flg = 0;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function deleteTopic($id = 0) {
    $sql = 'UPDATE topics SET del_flg = 1 WHERE id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }

  public function findTopicbyId($id = 0) {
    $sql = 'SELECT topics.id AS topic_id, users.name AS user_name, topics.user_id AS user_id, topics.title AS title, topics.body AS body FROM topics';
    $sql .= ' INNER JOIN users ON topics.user_id = users.id WHERE topics.id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public function updateTopic($id = 0) {
    if (isset($_POST['not_release'])) {
      $open = 0;
    } elseif (isset($_POST['release'])) {
      $open = 1;
    }
    $title = nl2br(htmlspecialchars($_POST['title'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $body = nl2br(htmlspecialchars($_POST['body'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $sql = 'UPDATE topics SET title = "'.$title.'", body = "'.$body.'", open_flg = "'.$open.'" WHERE id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    header("Location: ./topic_index.php");
    exit();
  }

  public function findTopicbyuserid($id = 0) {
    $sql = 'SELECT topics.id AS topic_id, topics.user_id AS user_id, topics.title AS title, topics.open_flg AS open_flg';
    $sql .= ' FROM topics INNER JOIN users ON topics.user_id = users.id WHERE topics.user_id = :id AND topics.del_flg = 0;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function countTopicbyuserid($id = 0) {
    $sql ='SELECT * FROM topics WHERE user_id = :id AND del_flg = 0 AND open_flg = 1;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $counttopic = $sth->rowCount();
    return $counttopic;
  }

  public function topicFavorite($id = 0) {
    $sql = 'INSERT INTO topicfavorites SET user_id = "'.$_SESSION['user_id'].'", topic_id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $url = "./topic_detail.php?id=" . $id;
    header("Location:" . $url);
    exit();
  }

  public function topicUnfavorite($id = 0) {
    $sql = 'DELETE FROM topicfavorites WHERE user_id = "'.$_SESSION['user_id'].'" AND topic_id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $url = "./topic_detail.php?id=" .$id;
    header("Location:" . $url);
    exit();
  }

  public function postComment() {
    $body = nl2br(htmlspecialchars($_POST['body'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $sql = 'INSERT INTO comments SET user_id = "'.$_POST['user_id'].'", topic_id = "'.$_POST['topic_id'].'", body = "'.$body.'", category = "'.$_POST['category'].'";';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $url = "./topic_detail.php?id=" . $_POST['topic_id'];
    header("Location:" . $url);
    exit();
  }

  public function findComment($id = 0) {
    $sql = 'SELECT users.name AS user_name, comments.body AS body, comments.user_id AS user_id, comments.topic_id AS topic_id, comments.category AS category, comments.id AS comment_id';
    $sql .= ' FROM (comments INNER JOIN users ON comments.user_id = users.id) INNER JOIN topics ON comments.topic_id = topics.id';
    $sql .= ' WHERE comments.topic_id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function findCommentbyId($id = 0) {
    $sql = 'SELECT id AS comment_id, body AS body, topic_id AS topic_id FROM comments WHERE id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  public function updateComment($id = 0) {
    $body = nl2br(htmlspecialchars($_POST['body'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $sql = 'UPDATE comments SET body = "'.$body.'" WHERE id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $url = "./comment_index.php?id=" .$_POST['topic_id'];
    header("Location:" .$url);
    exit();
  }

  public function deleteComment($id = 0) {
    $sql = 'SELECT id AS comment_id, body AS body, topic_id AS topic_id FROM comments WHERE id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $sql2 = 'DELETE FROM comments WHERE id = :id;';
    $sth2 = $this->dbh->prepare($sql2);
    $sth2->bindParam(':id', $id, PDO::PARAM_INT);
    $sth2->execute();
    $url = "./comment_index.php?id=" .$result['topic_id'];
    header("Location:" .$url);
    exit();
  }

  public function findCommentbyuserid($id = 0) {
    $sql = 'SELECT comments.id AS comment_id, topics.title AS title, comments.user_id AS user_id, comments.topic_id AS topic_id, comments.body AS body';
    $sql .= ' FROM (comments INNER JOIN users ON comments.user_id = users.id) INNER JOIN topics ON comments.topic_id = topics.id';
    $sql .= ' WHERE comments.user_id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function countCommentbyuserid($id = 0) {
    $sql = 'SELECT * FROM comments WHERE user_id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $countcomment = $sth->rowCount();
    return $countcomment;
  }

  public function commentFavorite($id = 0) {
    $sql = 'SELECT id AS comment_id, body AS body, topic_id AS topic_id FROM comments WHERE id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $sql2 = 'INSERT INTO commentfavorites SET user_id = "'.$_SESSION['user_id'].'", comment_id = :id;';
    $sth2 = $this->dbh->prepare($sql2);
    $sth2->bindParam(':id', $id, PDO::PARAM_INT);
    $sth2->execute();
    $url = "./comment_index.php?id=" .$result['topic_id'];
    header("Location:" . $url);
    exit();
  }

  public function commentUnfavorite($id = 0) {
    $sql = 'SELECT id AS comment_id, body AS body, topic_id AS topic_id FROM comments WHERE id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    $sql2 = 'DELETE FROM commentfavorites WHERE user_id = "'.$_SESSION['user_id'].'" AND comment_id = :id;';
    $sth2 = $this->dbh->prepare($sql2);
    $sth2->bindParam(':id', $id, PDO::PARAM_INT);
    $sth2->execute();
    $url = "./comment_index.php?id=" .$result['topic_id'];
    header("Location:" . $url);
    exit();
  }

  public function findTopicFavorite() {
    $sql = 'SELECT topicfavorites.topic_id AS topic_id, topicfavorites.user_id AS topicfavorites_userid, topics.user_id AS topics_userid FROM topicfavorites';
    $sql .= ' INNER JOIN topics ON topicfavorites.topic_id = topics.id;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function findCommentFavorite() {
    $sql = 'SELECT commentfavorites.comment_id AS comment_id, commentfavorites.user_id AS commentfavorites_userid, comments.user_id AS comments_userid FROM commentfavorites';
    $sql .= ' INNER JOIN comments ON commentfavorites.comment_id = comments.id;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
}
?>
