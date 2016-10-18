<?php
require(CLASS_PATH . 'auth.php');

class authController  {
  private $method = false;
  private $model;
  public $user;
  private $auth;

  public function __construct(){
    
    $this->auth = new auth(safe($_SESSION,'token'));
    if(!$this->auth ->checkToken()) {
//      $error = $auth->getAuthError();
    } else {
      $this->user = $this->auth->user; 
    }
  }
  
  public function render( $view, $model = null ){
    require( V_PATH.$view . ".php" );
  }
  
  public function showLoginForm(){
    $this->render('loginView');
  }
  
  public function login( $get ){
    $params = array_combine( $get['fields'], $get['values'] );
    $result = $this->auth->login( $params );
    if($result['code'] == 200){
      $this->user = $this->auth ->user; 
    }
    echo ($result['system_code']);
    
  }
  public function logout($get){
    unset ($this -> user);
    $this->auth->logout();
    $this->render('dashboardView');
  }  
  protected function checkAuth() {
    $headers = getallheaders ();
    if (isset ( $headers ['Authorization'] ) && $headers ['Authorization']) {
      $auth = new Auth($headers['Authorization']);

      $this->user = $auth->getUser();
      if ($this->user && $this->user['is_enabled'] == 0){
        return array (
            'result' => false,
            'system_code' => 'ERR_USER_DISABLED',
            'code' => '403'
        );
      }
      if ( $auth->checkToken() ) {
        return array (
            'result' => $this->user,
            'system_code' => 'SUCCESSFUL',
            'code' => '200'
        );
      } elseif ($auth->isTokenExists()) {
        return array (
            'result' => false,
            'system_code' => 'ERR_OUT_OF_DATE',
            'code' => '401'
        );
      } else {
        return array (
            'result' => false,
            'system_code' => 'ERR_INVALID_TOKEN',
            'code' => '403'
        );
      }
    } else {
      return array (
          'result' => false,
          'system_code' => 'ERR_TOKEN_MISSED',
          'code' => '403'
      );
    }
  }
}
