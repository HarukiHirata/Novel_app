<?php
require_once(ROOT_PATH .'/Models/Topic.php');

class TopicController {
  private $request;
  private $Topic;

  public function __construct() {
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;
    $this->Topic = new Topic;
  }

  public function topicpost() {
    $pos = $this->Topic->topost();
  }

  public function alltopic() {
    $topics = $this->Topic->findTopic();
    $params = [
      'topics' => $topics
    ];
    return $params;
  }

  public function topicdetail() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません。';
      exit;
    }

    $topic = $this->Topic->findTopicbyId($this->request['get']['id']);
    $params_det = [
      'topic' => $topic
    ];
    return $params_det;
  }

  public function topicupdate() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません。';
      exit;
    }

    $update = $this->Topic->updateTopic($this->request['get']['id']);
    return $update;
  }

  public function deltopic() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません。';
      exit;
    }

    $delete = $this->Topic->deleteTopic($this->request['get']['id']);
    return $delete;
  }

  public function findtopbyuserid() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $topbyuserid = $this->Topic->findTopicbyuserid($this->request['get']['id']);
    $params_topuserid = [
      'topics' => $topbyuserid
    ];
    return $params_topuserid;
  }

  public function counttopbyuserid() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $cotopbyuserid = $this->Topic->countTopicbyuserid($this->request['get']['id']);
    return $cotopbyuserid;
  }

  public function topicfavo() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $topicfavorite = $this->Topic->topicFavorite($this->request['get']['id']);
    return $topicfavorite;
  }

  public function topicunfavo() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $topicunfavorite = $this->Topic->topicUnfavorite($this->request['get']['id']);
    return $topicunfavorite;
  }

  public function poscom() {
    $compos = $this->Topic->postComment();
  }

  public function findcom() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $comfind = $this->Topic->findComment($this->request['get']['id']);
    $params_com = [
      'comments' => $comfind
    ];
    return $params_com;
  }

  public function findcombyid() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $combyid = $this->Topic->findCommentbyId($this->request['get']['id']);
    $params_comid = [
      'comment' => $combyid
    ];
    return $params_comid;
  }

  public function findcombyuserid() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $combyuserid = $this->Topic->findCommentbyuserid($this->request['get']['id']);
    $params_comuserid = [
      'comments' => $combyuserid
    ];
    return $params_comuserid;
  }

  public function countcombyuserid() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $cocombyuserid = $this->Topic->countCommentbyuserid($this->request['get']['id']);
    return $cocombyuserid;
  }

  public function commentupdate() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません。';
      exit;
    }

    $comupdate = $this->Topic->updateComment($this->request['get']['id']);
    return $comupdate;
  }

  public function commentdelete() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $comdelete = $this->Topic->deleteComment($this->request['get']['id']);
    return $comdelete;
  }

  public function commentfavo() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $commentfavorite = $this->Topic->commentFavorite($this->request['get']['id']);
    return $commentfavorite;
  }

  public function commentunfavo() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメータが不正です。このページを表示できません。';
      exit;
    }

    $commentunfavorite = $this->Topic->commentUnfavorite($this->request['get']['id']);
    return $commentunfavorite;
  }

  public function findtopfavo() {
    $topfavorites = $this->Topic->findTopicFavorite();
    $params_topfavo = [
      'topicfavorites' => $topfavorites
    ];
    return $params_topfavo;
  }

  public function findcomfavo() {
    $comfavorites = $this->Topic->findCommentFavorite();
    $params_comfavo = [
      'commentfavorites' => $comfavorites
    ];
    return $params_comfavo;
  }
}
?>
