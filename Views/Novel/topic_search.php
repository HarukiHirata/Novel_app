<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>結末をみんなで決める小説投稿サイト</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script>
    $(function(){
      $('#search_button').click(function() {
        var data = {request : $('#request').val()};
        $.ajax({
          type: "POST",
          url: "ajax_getData.php",
          data: data,

          success : function(data,dataType) {
            $('#res').html(data);
          },
          error : function() {
            alert('通信エラー');
          }
        });
        return false;
      });
    });
  </script>
</head>
<body>
  <div id="topic-index-wrapper">
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 0): ?>
      <header>
        <?php include(dirname(__FILE__)."/header_login.php"); ?>
      </header>
    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
      <header>
        <?php include(dirname(__FILE__)."/header_admin.php"); ?>
      </header>
    <?php else: ?>
      <header>
        <?php include(dirname(__FILE__)."/header_notlogin.php"); ?>
      </header>
    <?php endif; ?>
    <div class="title">
      <h1>投稿を検索</h1>
    </div>
    <div class="form-items">
      <div class="form-group">
        <form id="searchform" method="post">
          <input id="request" type="text" placeholder="タイトルで検索">
          <input id="search_button" class="submit-btn" type="submit" value="検索">
        </form>
      </div>
    </div>
    <div id="res"></div>
  </div>
</body>
</html>
