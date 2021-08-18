<?php
require_once(ROOT_PATH .'Controllers/TopicController.php');
$topic = new TopicController;
$update = $topic->topicupdate();
?>
