<?php
/*
 @class Context

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/

class Context {
  // $GV 변수는 공통 변수이므로 변경할 수 없음... 단 기본 변수에서 추가하는 역활은 구현하여도됨.

  private function __construct() { }

  protected static $instance = null;
  public static function getInstance() {
    if (!self::$instance) {
      return self::$instance = new self();
    }
    return self::$instance;
  }

  private $mid = NULL; // mid value
  private $module = NULL; // module value
  private $act = NULL; // act value
  public function setMid($mid) { $this->mid = $mid; }
  public function getMid() { return $this->mid; }
  public function setModule($module) { $this->module = $module; }
  public function getModule() { return $this->module; }
  public function setAct($act) { $this->act = $act; }
  public function getAct() { return $this->act; }

  public function getGV($name = NULL) { 
    global $GV;
    if (!is_null($name)) return $GV[$name];
    return $GV;
  }
  public function getPath($name = NULL) { 
    global $GV;
    return $GV['PATH'][$name];
  }

  private $MEI; // 기본설정 정보 (관리자 정보)
  public function setMei($value) { $this->MEI = $value; }
  public function getMei($name = NULL) { 
    if (!is_null($name)) return $this->MEI[$name];
    return $this->MEI; 
  }

  private $M; // 메인으로 지정된 모듈의 정보를 기록함. db 정보
  public function setM($value) { $this->M = $value; }
  public function getM($name = NULL) { 
    if (!is_null($name)) return $this->M[$name];
    return $this->M; 
  }

  private $LAYOUT; // 레이아웃 DB 정보
  public function setLayout($value) { $this->LAYOUT = $value; }
  public function getLayout($name = NULL) { 
    if (!is_null($name)) return $this->LAYOUT[$name];
    return $this->LAYOUT; 
  }

  private $layout_path = array(); // 현재 모듈 레이아웃 파일과 경로를 저장함.
  public function setLayoutPath($layout_path) { $this->layout_path = $layout_path; }
  public function getLayoutPath($name = NULL) { 
    if (!is_null($name)) return $this->layout_path[$name];
    return $this->layout_path; 
  }
  private $LAYOUT_HIDDEN = NULL; // 레이아웃 숨김여부
  public function setLayoutHidden($value) { $this->LAYOUT_HIDDEN = $value; }
  public function getLayoutHidden() { return $this->LAYOUT_HIDDEN; }

  // privileges
  private $privileges = NULL;
  public function setPrivileges($privileges) { $this->privileges = $privileges; }
  public function getPrivileges() { return $this->privileges; }
  // grant
  private $grant = NULL;
  public function setGrant($grant) { $this->grant = $grant; }
  public function getGrant($name = NULL) { 
    if (!is_null($name)) return $this->grant[$name];
    return $this->grant; 
  }

  private $browser_title = NULL; // 현재 브라우저 타이틀
  public function setBrowser_title($browser_title) { 
    if ( !empty($browser_title) ) $this->browser_title = $browser_title; 
  }
  public function getBrowser_title() { return $this->browser_title; }

  private $sid = NULL; // 세션 id
  private function setSid($sid) { $this->sid = $sid; }
  public function getSid() { return $this->sid; }

  private $is_mobile = FALSE;
  public function setIsMobile($is_mobile) { $this->is_mobile = $is_mobile; }
  public function getIsMobile() { return $this->is_mobile; }

  public function init() {
    global $GV;

    ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
    session_set_cookie_params(0,"/");
    session_save_path($this->getPath('DATA_PATH') . '/session');
    if ( $sess = $_POST[session_name()] ) session_id($sess);
    @session_start();
    $this->setSid(session_id());

    // _global.php 호출
    $modules = ModuleHandler::getModuleNames();
    $MODULES_PATH = $this->getPath('MODULES_PATH');
    foreach ($modules as $module) {
      $global = $MODULES_PATH . "/{$module}/_global.php";
      if (file_exists($global)) require_once $global;
    }

    // _global.php 호출 (레이아웃)
    $layouts = ModuleHandler::getLayoutList();
    $LAYOUTS_PATH = $this->getPath('LAYOUTS_PATH');
    foreach ($layouts as $layout) {
      $global = $LAYOUTS_PATH . "/{$layout}/_global.php";
      if (file_exists($global)) require_once $global;
    }


    // 기본 모듈
    $mid = _req_param('mid',NULL,TRUE);
    $module = _req_param('module',NULL,TRUE);
    $act = _req_param('act',NULL,true);

    // 설치 여부
    if ($this->isInstalled() == false && $module != 'install') {
      $this->setModule('install');
      return;
    }

    // 기본 설정
    if ($this->isDb() && $this->isInstalled()) {
    $MEI = ModuleObject::getConfig('admin','module');
    $this->setBrowser_title( $MEI['browser_title'] );
    $mobile = explode($MEI['options_mobile_target'],',');
    $this->setIsMobile( _is_mobile($mobile) );
    $this->setMei($MEI);

	// mid 와 module 이 빈값이고 기본 모듈이 있는 경우 mid를 기본 모듈로 적용.
    if ( empty($mid) && empty($module) && !empty($MEI['options_default_module']) ) $mid = ModuleDAO::getMid( $MEI['options_default_module'] );
    }

    $this->setMid($mid);
    $this->setModule($module);
    $this->setAct($act);
  }

  function isDb() {
    $__Db = Db::getInstance();
    return !is_null($__Db);
  }

  function isInstalled() {
    $installed = $this->getPath('DATA_PATH') . '/config/installed.php';
    return ( file_exists($installed) );
  }

  function close() {
    if(function_exists('session_write_close')) {
      @session_write_close();
    }

    $__Db = Db::getInstance();
    if(is_object($__Db) && method_exists($__Db, 'close')) {
      $__Db->close();
    }
  }

}
?>