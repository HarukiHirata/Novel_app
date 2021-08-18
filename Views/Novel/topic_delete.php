<?php
require_once(ROOT_PATH .'Controllers/TopicController.php');
$topic_del = new TopicController();
$delete = $topic_del->deltopic();
header("Location: ./topic_index.php");
exit();
?>
