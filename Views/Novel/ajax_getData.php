<?php
$title = $_POST['request'];

if (!empty($title)) {
  $pdo = new PDO('mysql:host=localhost;dbname=novel', 'root', 'suwa3217');
  $sql = "SELECT topics.title AS title, users.name AS username, topics.id AS topicid, topics.del_flg AS del_flg, topics.open_flg AS open_flg FROM topics";
  $sql.= " INNER JOIN users ON topics.user_id = users.id WHERE topics.title LIKE '%".$title."%';";
  $results = $pdo->query($sql);
  echo '<table border="1" style="width: 50vw;">';
  echo "<tr>";
  echo "<th>タイトル</th>";
  echo "<th>投稿者</th>";
  echo "<th>詳細</th>";
  echo "</tr>";

  foreach ($results as $result) {
    if ($result['del_flg'] == 0 && $result['open_flg'] == 1) {
      echo "<tr>";
      echo "<td>".$result['title']."</td>";
      echo "<td>".$result['username']."</td>";
      echo "<td>";
      echo "<a href='topic_detail.php?id=".$result['topicid']."'>";
      echo "詳細";
      echo "</a></td>";
      echo "</tr>";
    }
  }

  echo "</table>";
} else {
  echo "<p>検索するタイトルを入力してください。</p>";
}
