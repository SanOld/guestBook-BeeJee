<?php
require(C_PATH . '/authController.php');
require(M_PATH . '/editorFeedbackModel.php');
require(M_PATH . '/browserUserModel.php');

class editorFeedbackController extends authController
{
  public $model;
  public $rowid;
  public $user;
  public function __construct($rowid = null){
    parent::__construct();
    $this->rowid = $rowid ;
    $this->model = new editorFeedbackModel( 'feedback', $this->rowid );

    $this->feedbackUserModel = new browserUserModel('user');
  }

  public function edit( $arg = array() ){
    $this->render( 'editorFeedbackView', $this->model );
  }

  public function toggle( $arg = array() ){

    $query = $this->model->update( 'feedback', array('status'), array(!(int)$this->model->data['status']), $this->rowid );

    if($query){
      responseText('SUCCESSFUL', 'put');
    } else {
      responseText('ERROR', 'put');
    }
  }

  public function save($arg){

    $data = array_combine($arg['fields'], $arg['values']);
    $fields = array();
    $values = array();
    $fields[] = 'text';
    $values[] = $data['text'];
    if ($arg['photos'][0] != ''){
      $fileName = $this->getImageName($arg['photos'][0]);
      $fields[] = 'img';
      $values[] = $fileName;
    }

    if($this->rowid == 0){
      $this->feedbackUserModel->andWhere( 'name', $data['name'] , '=' );
      $this->feedbackUserModel->andWhere( 'email', $data['email']  , '=' );
      $feedbackUser = $this->feedbackUserModel->select('user');
      if(!is_array($feedbackUser || count($feedbackUser) == 0)){
        $user_id = $this->feedbackUserModel->insert('user', array('name', 'email'), array($data['name'] , $data['email']));
        $fields[] = 'user_id';
        $values[] = $user_id;
      } else {
        $user_id = array_shift($feedbackUser)['id'];
        $fields[] = 'user_id';
        $values[] = $user_id;
      }
        $result = $this->model->insert( 'feedback',$fields, $values );
    } else {

      if ($this->user['login'] == 'admin'){
        $fields[] = 'changed';
        $values[] = 1;
      }

      $result = $this->model->update( 'feedback', $fields, $values, $this->rowid );
      $this->model->refresh();
    }

    if(isset($arg['photos']) && count($arg['photos']) >= 1){
        $this->saveImage($arg['photos'][0], $fileName);
    }

    if($result){
      responseText('SUCCESSFUL', 'update');
    } else {
      responseText('ERROR', 'update');
    }
  }

  public function saveImage($fileBody, $fileName){

        // декодируем содержимое файла
        $fileBody = preg_replace('#^data.*?base64,#', '', $fileBody);
        $fileBody = base64_decode($fileBody);

        // сохраем файл
        file_put_contents(IMG_PATH . $fileName , $fileBody);

  }

  public function getImageName($fileBody = ''){
    if($fileBody != '')
    $fileName = md5(time() . $n); // генерируем рандомное название файла
    preg_match('#data:image\/(png|jpg|jpeg|gif);#', $fileBody, $fileTypeMatch);
    $fileType = $fileTypeMatch[1];

    return  $fileName . '.' . $fileType;
  }

}
