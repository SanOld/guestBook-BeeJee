<?php
require_once(CLASS_PATH . 'dataSource.php');
require_once(M_PATH . '/editorUserModel.php');


class editorFeedbackModel extends dataSource
{
  public $data;
  public $table;
  public $rowid;

  public function __construct($table, $rowid){
    parent::__construct();
    $this->table = $table;
    $this->rowid = $rowid;
    $this->data = $this->selectOne( $this->table, $this->rowid );
  }

  public function doAfterSelect($table, $data){
    $user = new editorUserModel('user', $data[$this->rowid]['user_id'] );
    $data[$this->rowid]['user'] = $user->data;
    return  $data;
  }   
    
  public function refresh(){
    $this->data = [];
    $this->data = $this->selectOne( $this->table, $this->rowid );
  }

}