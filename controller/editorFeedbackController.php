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
    $this->rowid = $rowid;
    $this->model = new editorFeedbackModel( 'feedback', $this->rowid );
    
    $this->feedbackUserModel = new browserUserModel('user');
  }
  
  public function edit( $arg = array() ){
    $this->render( 'editorFeedbackView', $this->model );
  }
  
  public function save($arg){
            
    $data = array_combine($arg['fields'], $arg['values']);
    $fields = array();
    $values = array();
    $fields[] = 'text';
    $values[] = $data['text'];
    
    if($this->rowid == 0){
      
      $this->feedbackUserModel->andWhere( 'name', $data['name'] , '=' );
      $this->feedbackUserModel->andWhere( 'email', $data['email']  , '=' );
      $feedbackUser = $this->feedbackUserModel->select('user');
        
      if(!$feedbackUser){
        $user_id = $this->feedbackUserModel->insert('user', array('name', 'email'), array($data['name'] , $data['email']));
        $fields[] = 'user_id';
        $values[] = $user_id;
      } else {      
        $user_id = array_shift($feedbackUser)['id'];
        $fields[] = 'user_id';
        $values[] = $user_id;
      }
        $this->model->insert( 'feedback',$fields, $values );
    } else {
      
      
      if ($this->user['login'] == 'admin'){
        $fields[] = 'changed';
        $values[] = 1;
      }

      $query = $this->model->update( 'feedback', $fields, $values, $this->rowid );
      $this->model->refresh();

      if($query){
        echo 'Данные успешно обновлены!';
      } else {
        echo 'Ошибка обновления!';
      }
      
    }
  }
  
  public function saveImage($arg){
    foreach ($arg['photos'] as $n => $fileBody) {
        $fileName = md5(time() . $n); // генерируем рандомное название файла

        // определяем формат файла
        preg_match('#data:image\/(png|jpg|jpeg|gif);#', $fileBody, $fileTypeMatch);
        $fileType = $fileTypeMatch[1];

        // декодируем содержимое файла
        $fileBody = preg_replace('#^data.*?base64,#', '', $fileBody);
        $fileBody = base64_decode($fileBody);
        
        // сохраем файл
        file_put_contents($fileName . '.' . $fileType, $fileBody);
    }
  }
   
}
