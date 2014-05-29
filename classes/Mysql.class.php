<?php
/**
  @class MySQL ver 2.1.0
  @brief database MySQL

  * registered date 2014-01-08
  * programmed by Seok Kyun. Choi. 최석균
  * http://syaku.tistory.com
  */

class Mysql {
  private $db_host = 'localhost';  // 호스트
  private $db_username = NULL; // 계정
  private $db_password = NULL; // 암호
  private $db_database = NULL; // 데이터베이스

  var $db = NULL;

  var $query = NULL;
  var $rows = 0;

  // 에러처리
  var $error = false;
  var $message = "";
  
  function __construct($db_host = NULL, $db_username = NULL, $db_password = NULL, $db_database = NULL) {
    if ( !is_null($db_host) ) { $this->db_host = $db_host; }
    if ( !is_null($db_username) ) { $this->db_username = $db_username; }
    if ( !is_null($db_password) ) { $this->db_password = $db_password; }
    if ( !is_null($db_database) ) { $this->db_database = $db_database; }

    $this->connect();
  }

  function connect($new_connect = false) {
    if(!$this->db || $new_connect){
      $this->db = @mysql_connect($this->db_host, $this->db_username, $this->db_password);

      if (!$this->db) {
        throw new Exception('DBMS 접근을 실패하였습니다.');
      } else {

        $select = @mysql_select_db($this->db_database, $this->db);
        if (!$select) throw new Exception('데이터베이스 접근에 실패하였습니다.');
        @mysql_query("set names 'utf8'",$this->db);
      }

    }
  }

  function close(){
    if($this->db != NULL) {
      @mysql_close($this->db);
    }
  }

  function begin() {
//    mysql_query('SET AUTOCOMMIT=0', $this->db);
    $r = @mysql_query('BEGIN', $this->db);
    if (!$r) $this->getException();
  }

  function rollback() {
    $r = @mysql_query("ROLLBACK", $this->db);
    if (!$r) $this->getException();
  }

  function commit() {
    $r = @mysql_query("COMMIT", $this->db);
    if (!$r) $this->getException();
  }

  function where($query) {
    $query = trim($query);
    $patten = "/^(AND|OR){1}/i";
    if ( !preg_match($patten,$query) ) return $query;
    return ' ' . preg_replace($patten,'WHERE',$query) . ' ';
  }

  function getException($e = NULL) {
    if ($e == NULL) $e = mysql_error();
    $message = $e . ' ==>>> debug query : ' . $this->query;
    throw new Exception($message);
  }

  private function getValueFormat($val, $addslashes) {
    $type = gettype($val);
    $value = ($addslashes) ? addslashes($val) : $val;

    switch ($type) {

      default :
      case 'string' : 
      case 'array' : 
      case 'object' : 
      case 'resource' : 
        $val = "'{$value}'";
      break;

      case 'boolean' : 
      case 'integer' : 
      case 'float' : 
      case 'double' : 
        $val = "{$value}";
      break;

      case 'NULL' : 
        $val = 'NULL';
      break;
    }
    
    return $val;
  }

  private function getIterate($value, $addslashes) {
    $values = '';
    foreach( $value as $v ) {
      $values .= $this->getValueFormat($v, $addslashes) . ', ';
    }
    return '(' . preg_replace('/,$/','',trim($values)) . ')';
  }

  /**
  $__Db = Db::getInstance();
  $doc = array( 
    'field' => array( 'a' , 'b' , 'c' ) ,
    'value' => array( 
      array('1','2','3'),
      array('1','2','3'),
      array('1','2','3'),
      array('1','2','3')
    ) 
  );

  $__Db->queryForInsert('install',$doc);
  echo $__Db->query;

  $doc2 = new stdClass();
  $doc2->a = '1';
  $doc2->b = '2';
  $doc2->c = '3';

  $__Db->queryForInsert('install',$doc2);
  echo $__Db->query;
  */

  function queryForInsert($table = NULL, $doc = NULL, $addslashes = FALSE) {
    if ( is_null($table) || is_null($doc) ) $this->getException('NULL POINT EXCEPTION');

    $fields = '';
    $values = '';

    $iterate = is_array($doc);
    if ( !is_array($doc) ) $doc = get_object_vars($doc);
    
    $iterate = ( isset($doc['value']) && is_array($doc['value']) );

    if ($iterate == FALSE) {

      foreach( $doc as $field => $value ) {
        $fields .= $field . ', ';
        $values .= $this->getValueFormat($value, $addslashes) . ', ';
      }

      $fields = preg_replace('/,$/','',trim($fields));
      $values = '(' . preg_replace('/,$/','',trim($values)) . ')';

    } else {
      $fields = join(',', $doc['field']);
      $value = $doc['value'];
      $values = '';
      foreach( $value as $k => $v ) {
        $values .= $this->getIterate($v,$addslashes) . ', ';
      }
      $values = preg_replace('/,$/','',trim($values));
    }

    $this->query = "INSERT INTO {$table} ( {$fields} ) VALUES {$values} ";
    return $this->insert();
  }

  function insert() {
    $r = mysql_query($this->query,$this->db);
    if (!$r) $this->getException();
    return mysql_insert_id();
  }

  function queryForUpdate($table = NULL, $doc = NULL, $set = NULL, $addslashes = FALSE) {
    if ( is_null($table) || is_null($doc) ) $this->getException('NULL POINT EXCEPTION');
    $document = '';
    
    if (is_object($doc)) $doc = get_object_vars($doc);

    foreach( $doc as $field => $value ) {
      $document .= "{$field} = " . $this->getValueFormat($value, $addslashes) . ', ';
    }
    
    $document = preg_replace('/,$/','',trim($document));

    $this->query = "UPDATE {$table} SET {$document} {$set} ";
    return $this->update();
  }

  function update() {
    if ( !mysql_query($this->query,$this->db) ) $this->getException();
    return mysql_affected_rows();
  }

  function del() {
    if ( !mysql_query($this->query,$this->db) ) $this->getException();
    return mysql_affected_rows();
  }

  function statement() {
    if ( !mysql_query($this->query,$this->db) ) $this->getException();
    return mysql_affected_rows();
  }

  function select() {
    $list = array();
    $r = $this->result();
    while ($rs = mysql_fetch_assoc($r)) array_push($list, $rs);
    @mysql_free_result($r);
    return $list;
  }

  function object() {
    $rs = NULL;
    $r = $this->result();
    if (mysql_num_rows($r) > 0) $rs = mysql_fetch_assoc($r);
    @mysql_free_result($r);
    return $rs;
  }

  function result() {
    $r = mysql_query($this->query,$this->db);
    if (!$r) $this->getException();
    return $r;
  }

}

?>