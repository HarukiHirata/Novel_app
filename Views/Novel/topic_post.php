<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/TopicController.php');
$topic_pos = new TopicController;
$topic_pos->topicpost();
?>
