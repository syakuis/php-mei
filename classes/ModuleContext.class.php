<?php
/*
 @class Context

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/

class ModuleContext {

  private $MOD; // 현재 모듈의 정보를 기록함. db 정보
  public function setMod($value) { $this->MOD = $value; }
  public function getMod($name = NULL) { 
    if (!is_null($name)) return $this->MOD[$name];
    return $this->MOD; 
  }

  // 현재 모듈의 시스템 정보를 기록함. _globals.php
  private $MOD_CONFIG;
  public function setModConfig($value) { $this->MOD_CONFIG = $value; }
  public function getModConfig() { return $this->MOD_CONFIG; }

  // 호출된 모듈 액션 정보를 기록함. module.xml
  private $ACT_CONFIG;
  public function setActConfig($value) { $this->ACT_CONFIG = $value; }
  public function getActConfig($name = NULL) { 
    if (!is_null($name)) return $this->ACT_CONFIG->{$name};
    return $this->ACT_CONFIG; 
  }

  private $template = NULL; // 현재 모듈 템플릿 파일
  public function setTemplate($template) { $this->template = $template; }
  public function getTemplate() { return $this->template; }
  
  private $skin_info = array(); // 현재 모듈 스킨 파일과 경로를 저장함.
  public function setSkinInfo($name, $value = NULL) { 
    if ( is_string($name) ) { $this->skin_info[$name] = $value; }
    else { $this->skin_info = $name; }
  }
  public function getSkinInfo($name = NULL) { 
    if (!is_null($name)) return $this->skin_info[$name];
    return $this->skin_info; 
  }
  
  // 임의의 변수 ValueStack
  private $V; // ValueStack 임의의 변수값
  public function put($name, $value) { 
    /*
        $Context = $this->Context;
    $GV = $Context->getGV();
    $M = $Context->getM();
    $GRANT = $Context->getGrant();
    $ModuleContext = $this->ModuleContext;
    $MOD = $ModuleContext->getMod();
    $ValueStack = $this->ValueStack;template 변수명 사용 금지
    */
    $this->V[$name] = $value;
  }
  public function get($name = NULL) { 
    if (!is_null($name)) return $this->V[$name];
    return $this->V;
  }
  public function remove($name) { 
    unset($this->{$name});
    $this->{$name} = NULL;
  }

  // result
  private $message = NULL;
  private $error = FALSE;
  public function setMessage($message) { $this->message = $message; }
  public function getMessage() { return $this->message; }
  public function setError($error) { $this->error = $error; }
  public function getError() { return $this->error; }
  public function resultError($message, $error = TRUE) {
    $this->setMessage($message);
    $this->setError($error);
    return $this;
  }

  private function __construct() { }
  protected static $instance = null;
  public static function getInstance($new = FALSE) {
    if (!self::$instance || $new) {
      return self::$instance = new self();
    }
    return self::$instance;
  }

}
?>