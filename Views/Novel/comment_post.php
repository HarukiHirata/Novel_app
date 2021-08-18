<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Controllers/TopicController.php');
$comment_pos = new TopicController;
$comment_pos->poscom();
?>
