<?php

class Db {

  public static function getInstance() {
    global $GV;

    static $inst = null;
    if ($inst === null) {
      $db_config = $GV['PATH']['DATA_PATH'] . '/config/db.php';
      if ( file_exists($db_config) ) {
        require_once $db_config;
        $inst = new Mysql($db_host,$db_username,$db_password,$db_database);
      }
    }
    return $inst;
  }

  private function __construct() {
  }

}
