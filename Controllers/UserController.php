<?php
require_once(ROOT_PATH .'/Models/User.php');

class UserController {
  private $request;
  private $User;

  public function __construct() {
    $this->request['get'] = $_GET;
    $this->request['post'] = $_POST;
    $this->User = new User;
  }

  public function userregi() {
    $regi = $this->User->userRegister();
  }

  public function log_in() {
    $login = $this->User->login();
  }

  public function passchange() {
    $password = $this->User->passwordChange();
  }

  public function adminregi() {
    $adregi = $this->User->adminRegister();
  }

  public function adlogin() {
    $adlogin = $this->User->adminlogin();
  }

  public function user_admin() {
    $users = $this->User->alluser();
    $params = [
      'users' => $users
    ];
    return $params;
  }

  public function userdelete() {
    if(empty($this->request['get']['id'])) {
      echo '指定のパラメーターが不正です。このページを表示できません。';
      exit;
    }
    $delete = $this->User->deleteuser($this->request['get']['id']);
    return $delete;
  }
}
?>
