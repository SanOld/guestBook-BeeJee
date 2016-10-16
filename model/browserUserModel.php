<?php
require_once(CLASS_PATH . 'dataSource.php');

class browserUserModel extends dataSource
{
    public $data;
    public function __construct( $table ){
      parent::__construct();
      $this->table = $table;
      $this->data = $this->select( $this->table );
    }
    
    public function refresh(){
      $this->data = [];
      $this->data = $this->select( $this->table );
    } 
     
}

