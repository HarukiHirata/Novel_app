<?php
require_once(ROOT_PATH .'Controllers/TopicController.php');
$comment = new TopicController;
$comupdate = $comment->commentupdate();
?>
