<?php
require_once(CLASS_PATH . 'dataSource.php');

class editorUserModel extends dataSource
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
    
    public function refresh(){
        $this->data = [];
        $this->data = $this->selectOne( $this->table, $this->rowid );
    }

}