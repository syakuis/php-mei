<?php

class InterceptorHandler {
  private $ACT_XML = NULL;
  private $ACT_CONFIG = NULL;
  private $act_before = NULL;
  private $act_after = NULL;
  private $interceptor = NULL;

  function InterceptorHandler($ACT_XML, $ACT_CONFIG) {
    $this->ACT_XML = $ACT_XML;
    $this->ACT_CONFIG = $ACT_CONFIG;
    $this->prepare();
  }

  private function prepare() {
    $interceptor = NULL;
    if (count($this->ACT_CONFIG->interceptor) > 0) {
      $interceptor = $this->ACT_CONFIG->interceptor;
    } else if (count($this->ACT_XML->interceptor) > 0) {
      $interceptor = $this->ACT_XML->interceptor;
    }
    $this->interceptor = $interceptor;
  }

  public function before() {
    if (is_null($this->interceptor)) return;
    
    foreach ($this->interceptor as $interceptor) {
      if ($interceptor['event'] == 'after') continue;
      $this->classInstance($interceptor['module'], $interceptor['class'], $interceptor['method']);
    }

  }

  public function after() {
    if (is_null($this->interceptor)) return;
    
    foreach ($this->interceptor as $interceptor) {
      if ($interceptor['event'] == 'before') continue;
      $this->classInstance($interceptor['module'], $interceptor['class'], $interceptor['method']);
    }

  }

  private function classInstance($module, $class, $method) {
    global $GV;

    $module = (string) $module;
    $class = (string) $class;
    $method = (string) $method;

    $class_file = $GV['PATH']['MODULES_PATH'] . "/{$module}/{$class}.php";
    if ( !file_exists($class_file) ) throw new Exception("{$class_file} :: Not found file.");
    require_once $class_file;
    if ( class_exists($class) ) {
      // 클래스 선언
      $instance = new $class();
      if( is_object($instance) ) {
        if ( method_exists($instance,$method) ) {
          $instance->{$method}();
        } else {
          throw new Exception("{$method} Not found method.");
        }
      }
    } else {
      throw new Exception("{$class} Not found class.");
    }
  }

}

?>