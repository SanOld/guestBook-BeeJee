<?php
require(M_PATH . '/editorUserModel.php');
class auth {
  public $token = '';
  public $user = array();
  public $live = 12;

  public function __construct($token = false, $user = false) {
    $this->db = new db();

    if($token) {
      $this->token = $token;
      if($user) {
        $this->user = $user;
      } else {

        $sql = "SELECT * FROM user WHERE auth_token='" . $token . "'";
        $query = $this->db->runQuery( $sql );

        if( $query ){
          $this->user  = mysql_fetch_assoc( $query );
          $this->token = $this->user['auth_token'];
        }
      }
    }
  }

  public function login($get) {



    if(safe($get, 'login') && safe($get, 'password') || safe($get, 'loginKey')) {

      if($key = safe($get, 'loginKey')) {
        $loginKey = explode(':',base64_decode($key));
        $login = $loginKey[0];
        $password = $loginKey[1];
      } else {
        $login = $get['login'];
        $password = $get['password'];
      }

      $sql = "SELECT * FROM user WHERE login='" . safe($get, 'login') . "' AND password = '". md5(safe($get, 'password')) . "'";
      $query = $this->db->runQuery( $sql );

      if( $query ){
        $this->user  = mysql_fetch_assoc( $query );
        $this->token = $this->user['token'];
      }

      if($this->user ) {
        $authToken = $this->user['auth_token'];
        $auth = new Auth($authToken, $this->user);
        if($authToken && $auth->checkToken()) {
          $toUpdate = array( 'auth_token_created_at' => date('Y-m-d H:i:s') );
        } else {
          $authToken = md5($password.'/'.strtotime('now'),false);
        }

        $this->model = new editorUserModel( 'user', $this->user['id'] );
        $this->model->update('user',array('auth_token', 'auth_token_created_at') ,array($authToken, date('Y-m-d H:i:s')) ,$this->user['id']);

        $this->user['auth_token'] = $authToken;
        $this->user['auth_token_created_at'] = $toUpdate['auth_token_created_at'];



        $res = array( 'result'      => true
                    , 'system_code' => 'LOGIN_SUCCESSFUL'
                    , 'code'        => '200'
                    , 'token'       => $authToken
                    , 'rights'      => $rights
                    , 'user'        => $this->user
                    , 'expiredAt'   => strtotime('+'.$this->live.' hour')
                    );

        $_SESSION['login'] = $login;
        $_SESSION['token'] = $authToken;

      } else {
        $res = array( 'result'      => false
                    , 'code'        => '401'
                    );
        if($this->user) {
          $res['system_code'] = 'ERR_USER_DISABLED';
        } else {
          $res['system_code'] = 'ERR_AUTH_FAILED';
        }
      }
    } else {
      $res = array( 'result'      => false
                  , 'system_code' => 'ERR_AUTH_FAILED'
                  , 'code'        => '401'
                  );
    }
    return $res;

  }
  public function logout(){
     $_SESSION = array();
     session_destroy();
     $this->user = array();
  }
  public function getUser() {
    return $this->user;
  }

  public function checkToken() {
    return (   $this->user['auth_token'] == $this->token
            && $this->user['auth_token_created_at']
            && strtotime($this->user['auth_token_created_at']) > strtotime('-'.$this->live.' hour')
          );
  }
  public function getAuthError() {

    if($this->user['auth_token'] != $this->token) {
      return array( 'result'      => false
                  , 'system_code' => 'ERR_INVALID_TOKEN'
                  , 'code'        => '401'
                  );
    } else if (!$this->user['auth_token_created_at'] || strtotime($this->user['auth_token_created_at']) < strtotime('-'.$this->live.' hour')) {
      return array( 'result'      => false
                  , 'system_code' => 'ERR_OUT_OF_DATE'
                  , 'code'        => '401'
                  );
    }
  }
  public function isTokenExists() {
    return $this->user['auth_token'];
  }

}