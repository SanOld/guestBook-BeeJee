<?php
class dataSource
{
  public $data = array();
  private $conditions;
    
  public function __construct(){
    $this->db = new db();
  }

  public function select( $table ) {
    $data = array();
    $result = $this->doBeforeSelect($table);  
    $data = $this->doSelect($table);
    $data = $this->doAfterSelect($table, $data);
    $this->conditions =  array();
      
    $this->data = $data; 
    return  $this->data;
  }
  public function doBeforeSelect( $table, $rowid = null ){
    $data = array();
    return  $data;
  } 
  public function doSelect( $table ){
    $data = array();
    
    $sql = "SELECT * FROM " . $table . $this->condition();

    $query = $this->db->runQuery( $sql );
  
    if($query){
      $dataquery  = mysql_fetch_assoc( $query );
      while($dataquery ){
        $data[ $dataquery['id'] ] = $dataquery;
        $dataquery  = mysql_fetch_assoc( $query );    
      }
    } else{
      return false;
    }
    
    return  $data;
  }
  public function doAfterSelect( $table, $data, $rowid = null ){
    return  $data;
  }  
  public function insert( $table, $fields = [], $values = [] ){
    $data = array();
    $result = $this->doBeforeInsert($table, $fields , $values );  
    $rowid = $this->doInsert($table, $fields , $values , $rowid);
    $this->doAfterInsert($table, $rowid); 
    $result = array();
    return  $rowid;
  }
  public function doBeforeInsert( $table, $fields = [], $values = [] ){
    $data = array();
    return  $data;
  } 
  public function doInsert($table, $fields = [], $values = []){
    $rowid = 0;
    $sql = "INSERT INTO " . $table . " ( " . implode(", ", $fields) . ") VALUES ( '" . implode("', '", $values) . "')";
    $query = $this->db->runQuery( $sql );  
    if($query){
      $rowid = mysql_insert_id();
    }
    
    return $rowid;
  }
  public function doAfterInsert( $table, $data ){
    return  $data;
  }
  public function update($table, $fields=[], $values=[], $rowid){
    $set = ''; 
    $arr = array();
    $i = count( $fields );
    while( $i-- ){
        $arr[] = ( $fields[$i] . " = '" . $values[$i] . "'" );
    }
    if(is_array( $arr )) {
        $set = implode( ", ", $arr );
    }
    $sql = "UPDATE $table SET " . $set . " WHERE id= '" . $rowid ."'";
    $query = $this->db->runQuery( $sql );

    return $query;
  }
  public function delete( $table, $rowid ){
    $sql = "DELETE  FROM " . $table . " WHERE id='" . $rowid . "'";
    $query = $this->db->runQuery( $sql );
    return $query;
  }
  public function selectOne( $table, $rowid ){
    $this->andWhere('id', $rowid, '=');
    $data = $this->select($table);
    $this->data = $data[$rowid]; 
    return  $this->data;
  }
  
  private function condition(){
    $result = '';
    if (isset($this->conditions['where'])){
      $result = ' WHERE 1=1 '. $this->conditions['where'];
    }
    if (isset($this->conditions['orderASC'])){
      $result .= ' ORDER BY '. $this->conditions['orderASC'] . ' ASC';
    } elseif(isset($this->conditions['orderDESC'])){
      $result .= ' ORDER BY '. $this->conditions['orderDESC'] . ' DESC';
    } 
    
    return $result;
  }
  public function andWhere($field, $value, $compare){
    $result = "AND `" . $field . "`" . $compare . "'" . $value . "'";
    $this->conditions['where'] .= $result;
  }
  public function orWhere($field, $value, $compare){
    $result = " OR `" . $field . "`" . $compare . "'" . $value . "'";
    $this->conditions['where'] .= $result;
  }  
  public function orderASC($field){
    $result = $field;
    $this->conditions['orderASC'] .= $result;
  }     
  public function orderDESC($field){
    $result = $field;
    $this->conditions['orderDESC'] .= $result;
  } 
}
