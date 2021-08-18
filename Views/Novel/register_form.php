<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>結末をみんなで決める小説投稿サイト</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/css/base.css">
</head>
<body>
  <div id="register-wrapper">
    <header>
      <?php include(dirname(__FILE__)."/header_notlogin.php"); ?>
    </header>
    <div class="title">
      <h1>新規会員登録</h1>
    </div>
    <?php if (!empty($_SESSION['errormsg'])) {
      foreach ($_SESSION['errormsg'] as $error) {
        echo $error;
        echo "<br>";
      }
    };
    ?>
    <?php if (!empty($_SESSION['emailused'])) {
      echo $_SESSION['emailused'];
      echo "<br>";
    }
    ?>
    <?php if (empty($_SESSION['errormsg']) && empty($_SESSION['emailused'])): ?>
      <div class="form-items">
        <form method="post" action="user_register.php">
          <div class="form-group">
            <label>名前</label>
            <input type="text" class="form-control col-8" name="name">
          </div>
          <div class="form-group">
            <label>メールアドレス</label>
            <input type="text" class="form-control col-8" name="email">
          </div>
          <div class="form-group">
            <label>パスワード（半角英数字8文字以上で入力）</label>
            <input type="password" class="form-control col-8" name="password">
          </div>
          <div class="form-group">
            <label>パスワード確認用</label>
            <input type="password" class="form-control col-8" name="password_confirm">
          </div>
          <div class="form-group">
            <label>秘密の言葉（パスワード変更時使用）</label>
            <input type="text" class="form-control col-8" name="secret_word">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info">会員登録</button>
          </div>
        </form>
      </div>
    <?php else: ?>
      <div class="form-items">
        <form method="post" action="user_register.php">
          <div class="form-group">
            <label>名前</label>
            <input type="text" class="form-control col-8" name="name" value="<?php if (!empty($_SESSION['nameer'])) echo ($_SESSION['nameer']); ?>">
          </div>
          <div class="form-group">
            <label>メールアドレス</label>
            <input type="text" class="form-control col-8" name="email" value="<?php if (!empty($_SESSION['emailer'])) echo ($_SESSION['emailer']); ?>">
          </div>
          <div class="form-group">
            <label>パスワード（半角英数字8文字以上で入力）</label>
            <input type="password" class="form-control col-8" name="password" value="<?php if (!empty($_SESSION['passworder'])) echo ($_SESSION['passworder']); ?>">
          </div>
          <div class="form-group">
            <label>パスワード確認用</label>
            <input type="password" class="form-control col-8" name="password_confirm">
          </div>
          <div class="form-group">
            <label>秘密の言葉（パスワード変更時使用）</label>
            <input type="text" class="form-control col-8" name="secret_word" value="<?php if (!empty($_SESSION['secret_worder'])) echo ($_SESSION['secret_worder']); ?>">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-info">会員登録</button>
          </div>
        </form>
      </div>
    <?php endif; ?>
  </div>
</body>
<?php
unset($_SESSION['errormsg']);
unset($_SESSION['emailused']);
unset($_SESSION['nameer']);
unset($_SESSION['emailer']);
unset($_SESSION['passworder']);
unset($_SESSION['secret_worder']);
?>
