<?php

class ValueStack {

  private function __construct() { }

  protected static $instance = null;
  public static function getInstance() {
    if ( !self::$instance ) {
      return self::$instance = new self();
    }
    return self::$instance;
  }


  // 임의의 변수 ValueStack
  private $V; // ValueStack 임의의 변수값
  public function put($module, $name, $value) { 
    $this->V[$module][$name] = $value;
  }
  public function get($module, $name = NULL) { 
    if ( $name != NULL ) return $this->V[$module][$name];
    return $this->V[$module];
  }

}

?>