<?php
require_once(ROOT_PATH .'Controllers/TopicController.php');
$comment = new TopicController;
$comdelete = $comment->commentdelete();
?>
