<?php
class db
{
  private $connection;
  private $ownConnection;
  private $config;

  function __construct( $cfg = null ) {

    $this->connect(DB_SERVER, DB_NAME, DB_USER, DB_PASSWORD, $cfg);

  }

  function connect($hostName, $dataBaseName, $userName, $password, $cfg) {

      $this->connection = mysql_connect($hostName, $userName, $password, true);
      mysql_select_db($dataBaseName, $this->connection);



    if (!is_null($cfg->connection)) {
      $this->connection = $cfg['connection'];
      $this->ownConnection = false;
    } else {
      try {
        if ($this->connection = mysql_connect($hostName, $userName, $password, true)) {
          $this->ownConnection = true;
          mysql_select_db($dataBaseName, $this->connection);
          mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
          mysql_query("SET CHARACTER SET 'utf8'");
        }
      } catch (Exception $e) {
        $this->connection = null;

      }
    }



  }

    function runQuery($sql) {
      $query = mysql_query($sql, $this->connection);

      if(mysql_errno()!=0) {
        echo "ERROR ".mysql_errno()." ".mysql_error()."\n";
        return false;
      }
        return $query;
      }
}
