<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once(ROOT_PATH .'Models/Db.php');

class User extends Db {
  public function __construct($dbh = null) {
    parent::__construct($dbh);
  }

  public function userRegister() {
    $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute(array(':email' => $_POST['email']));
    $result = $sth->fetch();
    if ($result > 0) {
      $_SESSION['emailused'] = 'このメールアドレスはすでに使われています。';
      $_SESSION['nameer'] = nl2br(htmlspecialchars($_POST['name'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
      $_SESSION['emailer'] = nl2br(htmlspecialchars($_POST['email'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
      $_SESSION['passworder'] = nl2br(htmlspecialchars($_POST['password'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
      $_SESSION['passwordconfirmer'] = nl2br(htmlspecialchars($_POST['password_confirm'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
      $_SESSION['secret_worder'] = nl2br(htmlspecialchars($_POST['secret_word'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
      header("Location: ./register_form.php");
      exit();
    } else {
      $name = nl2br(htmlspecialchars($_POST['name'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
      $email = nl2br(htmlspecialchars($_POST['email'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $secret_word = nl2br(htmlspecialchars($_POST['secret_word'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
      $sql2 = 'INSERT INTO users SET name="'.$name.'",email="'.$email.'",password="'.$password.'",secret_word="'.$secret_word.'",role=0,del_flg=0;';
      $sth2 = $this->dbh->prepare($sql2);
      $sth2->execute();
      $sql3 = 'SELECT * FROM users WHERE email = :email;';
      $sth3 = $this->dbh->prepare($sql3);
      $sth3->execute(array(':email' => $_POST['email']));
      $result2 = $sth3->fetch(PDO::FETCH_ASSOC);
      session_regenerate_id(true);
      $_SESSION['user_id'] = $result2['id'];
      $_SESSION['name'] = $result2['name'];
      $_SESSION['role'] = $result2['role'];
      header("Location: ./topic_index.php");
      exit();
    }
  }

  public function login() {
    $email = nl2br(htmlspecialchars($_POST['email'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $sql = 'SELECT * FROM users WHERE email = :email AND del_flg = 0 LIMIT 1;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute(array(':email' => $email));
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    if (isset($result['email']) && password_verify($_POST['password'], $result['password']) && $result['role'] == 0) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $result['id'];
      $_SESSION['name'] = $result['name'];
      $_SESSION['role'] = $result['role'];
      header("Location: ./topic_index.php");
      exit();
    } else {
      $_SESSION['loginer'] = 'ログインに失敗しました。';
      header("Location: ./login_form.php");
      exit();
    }
  }

  public function passwordChange($id = 0) {
    $email = nl2br(htmlspecialchars($_POST['email'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $secret_word = nl2br(htmlspecialchars($_POST['secret_word'], ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    $sql = 'SELECT * FROM users WHERE email = :email AND secret_word = :secret_word AND del_flg = 0 LIMIT 1;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute(array(':email' => $email, ':secret_word' => $secret_word));
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    if ($result > 0 && $result['role'] == 0) {
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $sql2 = "UPDATE users SET password = '" .$password. "' WHERE id = :id;";
      $sth2 = $this->dbh->prepare($sql2);
      $sth2->bindParam(':id', $result['id'], PDO::PARAM_INT);
      $sth2->execute();
      session_regenerate_id(true);
      $_SESSION['user_id'] = $result['id'];
      $_SESSION['name'] = $result['name'];
      $_SESSION['role'] = $result['role'];
      header("Location: ./topic_index.php");
      exit();
    } elseif ($result > 0 && $result['role'] == 1) {
      $_SESSION['passwordchangeer'] = '管理者はパスワード変更できません。';
      header("Location: ./passwordchange_form.php");
      exit();
    } else {
      $_SESSION['passwordchangeer'] = 'メールアドレスが登録されていないか秘密の言葉が間違っています。';
      header("Location: ./passwordchange_form.php");
      exit();
    }
  }

  public function adminRegister() {
    $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute(array(':email' => $_POST['email']));
    $result = $sth->fetch();
    if ($result > 0) {
      $_SESSION['ademailused'] = 'このメールアドレスはすでに使われています。';
      $_SESSION['adnameer'] = $_POST['name'];
      $_SESSION['ademailer'] = $_POST['email'];
      $_SESSION['adpassworder'] = $_POST['password'];
      $_SESSION['adpasswordconfirmer'] = $_POST['password_confirm'];
      header("Location: ./admin_register_form.php");
      exit();
    } else {
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $sql2 = 'INSERT INTO users SET name="'.$_POST['name'].'",email="'.$_POST['email'].'",password="'.$password.'",role=1,del_flg=0;';
      $sth2 = $this->dbh->prepare($sql2);
      $sth2->execute();
      $sql3 = 'SELECT * FROM users WHERE email = :email;';
      $sth3 = $this->dbh->prepare($sql3);
      $sth3->execute(array(':email' => $_POST['email']));
      $result2 = $sth3->fetch(PDO::FETCH_ASSOC);
      session_regenerate_id(true);
      $_SESSION['user_id'] = $result2['id'];
      $_SESSION['name'] = $result2['name'];
      $_SESSION['role'] = $result2['role'];
      header("Location: ./topic_index.php");
      exit();
    }
  }

  public function adminlogin() {
    $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute(array(':email' => $_POST['email']));
    $result = $sth->fetch(PDO::FETCH_ASSOC);

    if (isset($result['email']) && password_verify($_POST['password'], $result['password'])) {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $result['id'];
      $_SESSION['name'] = $result['name'];
      $_SESSION['role'] = $result['role'];
      header("Location: ./topic_index.php");
      exit();
    } else {
      $_SESSION['loginer'] = 'ログインに失敗しました。';
      header("Location: ./admin_login_form.php");
      exit();
    }
  }

  public function alluser():Array {
    $sql = 'SELECT id AS user_id, name AS user_name, email AS user_email FROM users WHERE del_flg = 0;';
    $sth = $this->dbh->prepare($sql);
    $sth->execute();
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function deleteuser($id = 0) {
    $sql = 'UPDATE users SET del_flg = 1 WHERE id = :id;';
    $sth = $this->dbh->prepare($sql);
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->execute();
  }
}
?>
