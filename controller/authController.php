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

  public function actionUploadFile($model) {
    function toBytes($str){
      $val = trim($str);
      $last = strtolower($str[strlen($str)-1]);
      switch($last) {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
      }
      return $val;
    }
    $dirpath = 'uploads/'.$model.'/';
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
      $id = $_GET['id'];
      unset($_GET['id']);
      $strlength = strlen($id);
      for($i=0;$i<$strlength;$i++){
        $dirpath .=substr($id, $i, 1).'/';
      }
    }
    
    $allowedExtensions = array('jpg','jpeg','png', 'gif', 'doc', 'docx', 'pdf', 'csv');
    $sizeLimit = 10 * 1024 * 1024; // 10 Mb
    $postSize = toBytes(ini_get('post_max_size'));
    $uploadSize = toBytes(ini_get('upload_max_filesize'));
    $sizeLimit = min($sizeLimit, $postSize, $uploadSize);
    $path = $_SERVER['DOCUMENT_ROOT'].'/'.$dirpath;
    mk_dir($path);
    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
    $result = $uploader->handleUpload($path);
    
    if(safe($result, 'success')) {
      $models = $models_prot = array_map('trim', explode(',', MODELS));
      $models = array_change_case($models);
      $key = array_search(self::getClassName($_GET['model']), $models);
      if($key !== false) {
        $modelFor = $models_prot[$key]; // unix files 'user' and 'User' are not equal
      } else {
        response('405', array('system_code' => 'ERR_SERVICE'));
      }
      $this -> model = CActiveRecord::model($modelFor);

      if($result['extention'] == 'csv'){
        $file = $result['directory'].$result['filename'];
        $result = $this -> model -> addContent($file);
      }else{
        $headers = getallheaders ();
        $this -> method = strtolower($_SERVER['REQUEST_METHOD']);
        $auth = new Auth(safe($headers,'Authorization'));

        if(!$auth ->checkToken()) {
          $error = $auth->getAuthError();
          response('401', $error);
        }

        $this -> user = $auth -> user;
        if(!$auth->user['can_edit']) {
          $this->sendPermissionError();
        }
        $result = $this -> model -> addFile($id, $uploader->getName(), $dirpath.$result['filename']);
      }

    }
    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
}
