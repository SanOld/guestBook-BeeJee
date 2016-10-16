<?php
require_once(CLASS_PATH . 'dataSource.php');
require_once(M_PATH . '/editorUserModel.php');

class browserFeedbackModel extends dataSource
{
    public $data;
    public function __construct( $table ){
      parent::__construct();
      $this->table = $table;
      $this->data = $this->select( $this->table );
    }
    
    public function doAfterSelect($table, $data){
      $data = $data;
      foreach($data as &$feedback){
        $user = new editorUserModel('user', $feedback['user_id'] );
        $feedback['user'] = $user->data;
      }      
      return  $data;
    }     
    
    public function refresh(){
      $this->data = [];
      $this->data = $this->select( $this->table );
    } 

}

