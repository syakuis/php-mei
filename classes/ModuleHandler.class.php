<?php

class ModuleHandler {

  private function __construct() { }

  // 우선 순위 모듈 선정 : 1. mid 2. module
  public static function getFistModule($mid, $module) {
    if ( !empty($mid) ) return 'mid';
    if ( !empty($module) ) return 'module';
    return NULL;
  }

  // 모듈을 호출하고 결과를 반환함.
  public function getModuleContent($kind, $module, $act = NULL) {
    $ModuleContext = self::getModule($kind, $module, $act);
    $DisplayHandler = new DisplayHandler($ModuleContext);
    return  $DisplayHandler->getContent();
  }

  public static function getModuleInstance($kind = NULL, $module = NULL, $act = NULL) {
    global $GV;
    $Context = Context::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $MEI = $Context->getMei();

    if ($Context->isDb() && $Context->isInstalled() && !empty($module)) $M = ModuleObject::getConfig($module, $kind);
    if ( $kind == 'mid' && empty($M) ) throw new Exception("Not found module.");

    if ( !empty($M) ) {
      $Context->setBrowser_title($M['browser_title']); // 브라우저 타이틀
      $Context->setM( $M );
    }

    $PRIVILEGES = NULL;
    if ( !empty($M['module_orl']) ) $PRIVILEGES = ModuleObject::getGrant($M['module_orl']);
    $GRANT = MemberObject::getGrant($PRIVILEGES);
    $GRANT['GRANT_LOGIN'] = $GRANT['login'];
    $GRANT['GRANT_ACCESS'] = $GRANT['access'];
    $GRANT['GRANT_LIST'] = $GRANT['list'];
    $GRANT['GRANT_VIEW'] = $GRANT['view'];
    $GRANT['GRANT_WRITE'] = $GRANT['write'];
    $GRANT['GRANT_COMMENT'] = $GRANT['comment'];
    $GRANT['GRANT_MINE'] = $GRANT['mine'];
    $GRANT['GRANT_MANAGER'] = $GRANT['manager'];
    $GRANT['GRANT_ADMIN'] = $GRANT['admin'];
    $Context->setGrant($GRANT);

    // 레이아웃 정보
    $layout_orl = $M['layout_orl'];
    if( !empty($layout_orl) ) { 
      $LAYOUT = LayoutObject::getConfig($layout_orl);

      // 레이아웃 경로
      $LAYOUT_PATH['LAYOUT_PATH'] = $GV['PATH']['LAYOUTS_PATH'] . "/{$LAYOUT['layout']}";
      $LAYOUT_PATH['LAYOUT_R_PATH'] = $GV['PATH']['LAYOUTS_R_PATH'] . "/{$LAYOUT['layout']}";
      $LAYOUT_PATH['LAYOUT_FILE'] = 'layout.php';
      $Context->setLayout( $LAYOUT );
      $Context->setLayoutPath($LAYOUT_PATH);
    }

    $org_module = ( $kind == 'mid' ) ? $M['module'] : $module;
    if ($act != NULL) {
      $action = self::getAction($act, NULL);
    } else {
      $action = self::getAction($act, $org_module);
    }
    $ACT_XML = $action['ACT_XML'];
    $ACT_CONFIG = $action['ACT_CONFIG'];
    $act_module = (string)$ACT_XML['name'];
    $act = (string)$ACT_CONFIG['name'];

    if ( empty($ACT_CONFIG) ) throw new Exception("[actionConfig] {$act} :: Not found method.");

    if ($act_module != $org_module ) {
      $module = $act_module;
      $kind = 'module';
    }

    return self::getModule($kind, $module, $act, FALSE);
  }

  // 모듈 실행
  public static function getModule($kind, $module, $act = NULL, $instance = TRUE) {
    global $GV;
    $Context = Context::getInstance();
    $GV = $Context->getGV();
    $GRANT = $Context->getGrant();

    $ModuleContext = ModuleContext::getInstance($instance);

    if ( empty($module) ) throw new Exception("{getModule} Not found module.");

    if ($Context->isDb() && $Context->isInstalled()) $MOD = ModuleObject::getConfig($module, $kind);

    if ( $kind == 'mid' ) $module = $MOD['module'];
    if ( empty($module) ) throw new Exception("{getModule} Failed access to the module.");

    // 모듈 액션 정보
    $ACT_XML = self::actionXml($module);
    $ACT_CONFIG = self::actionConfig($ACT_XML->action,$act);

    if ( empty($ACT_CONFIG) ) throw new Exception("[actionConfig] {$act} :: Not found method.");

    if ( $kind == 'mid' ) $module = $MOD['module'];
    if ( empty($module) ) throw new Exception("{getModule} Failed access to the module.");

    $ModuleContext->setMod( $MOD );
    $ModuleContext->setActConfig( $ACT_CONFIG );

    $act_module = (string) $ACT_CONFIG['module'];
    $module = _empty($act_module, $module);
    $class = (string) $ACT_CONFIG['class'];
    $method = (string) $ACT_CONFIG['method'];
    $target = (string) $ACT_CONFIG['target'];
    $template = (string) $ACT_CONFIG->template;
    $permission = (string) $ACT_CONFIG->permission;
    $act_result =(string) _empty($ACT_CONFIG->result, 'html');

    // 현재 모듈의 시스템 정보
    $MOD_CONFIG = $GV[self::getGVName($module)];
    $ModuleContext->setModConfig( $MOD_CONFIG );

//	if ($MOD_CONFIG['SINGLE'] == FALSE && $kind == 'module') throw new Exception("{getModule} Is not a valid path.");
/*
	echo '$kind/$module : '; echo "{$kind}/{$module} <br />";
	echo '$M : '; print_r($Context->getM()); echo "<br />";
	echo '$MOD : '; print_r($MOD); echo "<br />";
	echo '$MOD_CONFIG : '; print_r($MOD_CONFIG); echo "<br />";
*/
    // 스킨정보
    if ( !empty($MOD['skin']) && isset($MOD_CONFIG['SKINS_PATH']) && $target != 'admin') {
      $SKIN_INFO['SKIN_PATH'] = "{$MOD_CONFIG['SKINS_PATH']}/{$MOD['skin']}";
      $SKIN_INFO['SKIN_R_PATH'] = "{$MOD_CONFIG['SKINS_R_PATH']}/{$MOD['skin']}";
    } else {
      $SKIN_INFO['SKIN_PATH'] = "{$MOD_CONFIG['MODULE_PATH']}/tpl";
      $SKIN_INFO['SKIN_R_PATH'] = "{$MOD_CONFIG['MODULE_R_PATH']}/tpl";
    }

    $ModuleContext->setTemplate($template);
    $SKIN_INFO['SKIN_FILE'] = "{$SKIN_INFO['SKIN_PATH']}/{$template}";
    $ModuleContext->setSkinInfo($SKIN_INFO);
    
    // 권한 체크
    if ($act_result != 'html' ) {
      if ($permission == 'member') if (!$GRANT['GRANT_LOGIN']) return $ModuleContext->resultError("권한이 없습니다.");
      if ($permission == 'manager') if (!$GRANT['GRANT_MANAGER']) return $ModuleContext->resultError("권한이 없습니다.");
    } else {
      $access = TRUE;
      if ($permission == 'member') if (!$GRANT['GRANT_LOGIN']) $access = FALSE;
      if ($permission == 'manager') if (!$GRANT['GRANT_MANAGER']) $access = FALSE;
      if ($access == FALSE) {
        return self::getModule('module', 'member', 'dispMemberLogin', FALSE);
      }
    }

    $interceptor = new InterceptorHandler($ACT_XML, $ACT_CONFIG);
    $interceptor->before();
    // 모듈 require_once
    $class_file = $GV['PATH']['MODULES_PATH'] . "/{$module}/{$class}.php";
    if ( !file_exists($class_file) ) throw new Exception("{$class_file} :: Not found file.");
    require_once $class_file;
    $result = self::classInstance($class, $method);
    $interceptor->after();
    return $result;
  }

  private static function classInstance($class, $method) {
    if ( class_exists($class) ) {
      // 클래스 선언
      $instance = new $class();
      if( is_object($instance) ) {
        if ( method_exists($instance,$method) ) {
          return $instance->{$method}();
        } else {
          throw new Exception("{$method} Not found method.");
        }
      }
    } else {
      throw new Exception("{$class} Not found class.");
    }
  }

  // 모든 모듈명 가져오기
  public static function getModuleNames() {
    global $GV;

    $return = array();
    $modules = dir($GV['PATH']['MODULES_PATH']);
    while ($module = $modules->read()) {
      if ( preg_match("/[A-Za-z0-9_]+$/i", $module) ) array_push($return,$module);
    }
    return $return;
  }

  // 전역변수 모듈명으로 변경하여 반환
  public static function getGVName($module) {
    return '_' . strtoupper($module) . '_';
  }

  private static function getAction($act = NULL, $module = NULL) {
    $result = NULL;

    if ($module == NULL && $act != NULL) {

      foreach(self::getModuleNames() as $v) {
        $ACT_XML = self::actionXml($v);
        $ACT_CONFIG = self::actionConfig($ACT_XML->action, $act);
        if ($ACT_CONFIG != NULL) {
          $result['ACT_XML'] = $ACT_XML;
          $result['ACT_CONFIG'] = $ACT_CONFIG;
          break;
        }
      }

    } else {
      $ACT_XML = self::actionXml($module);
      $ACT_CONFIG = self::actionConfig($ACT_XML->action, $act);
      $result['ACT_XML'] = $ACT_XML;
      $result['ACT_CONFIG'] = $ACT_CONFIG;
    }

    return $result;
  }

  // module.xml 읽기
  public static function actionXml($module) {
    global $GV;

    if ( empty($module) ) throw new Exception("[actionConfig] NULL Point Exception.");
    $path = $GV['PATH']['MODULES_PATH'] . "/{$module}/module.xml";
    if ( !file_exists($path) ) throw new Exception("[actionConfig] {$path} :: Not found file.");
    return simplexml_load_file($path);
  }
  public static function actionConfig($actions, $act = NULL) {
    $index = NULL;

    foreach ($actions as $obj) {
      if ($obj['index'] == TRUE && $act == NULL) $index = $obj;
      if ($act == $obj['name']) return $obj;
    }

//    if ( !empty($act) ) throw new Exception("[actionConfig] {$act} :: Not found method.");
    return $index;
  }

  // 스킨변경
  public static function setSkinChange($skin = NULL, $template = NULL) {
    $ModuleContext = ModuleContext::getInstance();
    if ($template == NULL) $template = $ModuleContext->getTemplate();

    $MOD_CONFIG = $ModuleContext->getModConfig();
	if ( $skin != NULL && $skin != 'tpl' ) {
		$ModuleContext->setSkinInfo('SKIN_PATH', "{$MOD_CONFIG['SKINS_PATH']}/{$skin}");
		$ModuleContext->setSkinInfo('SKIN_R_PATH', "{$MOD_CONFIG['SKINS_R_PATH']}/{$skin}");
		$ModuleContext->setSkinInfo('SKIN_FILE', "{$MOD_CONFIG['SKINS_PATH']}/{$skin}/{$template}");
	}

	if ( $skin == 'tpl' ) {
		$ModuleContext->setSkinInfo('SKIN_PATH', "{$MOD_CONFIG['MODULE_PATH']}/tpl");
		$ModuleContext->setSkinInfo('SKIN_R_PATH', "{$MOD_CONFIG['MODULE_R_PATH']}/tpl");
		$ModuleContext->setSkinInfo('SKIN_FILE', "{$MOD_CONFIG['MODULE_PATH']}/tpl/{$template}");
	}

	if ($template != NULL) {
		$SKIN_PATH = $ModuleContext->getSkinInfo('SKIN_PATH');
		$ModuleContext->setSkinInfo('SKIN_FILE', "{$SKIN_PATH}/{$template}");
	}
  }

  // 스킨 목록
  public static function getSkinList($module) {
    return self::getDir($module,"/[A-Za-z0-9_]+$/i");
  }

  // 레이아웃 목록
  public static function getLayoutList() {
    global $GV;
    $path = $GV['PATH']['LAYOUTS_PATH'];
    return self::getDir($path,"/[A-Za-z0-9_]+$/i");
  }

  // 폴더 목록
  public static function getDir($path, $filter = NULL) {
    $list = array();
    $dirs = dir($path);
    $dir_path = $dirs->path;
    while ($dir = $dirs->read()) {
      if ( !is_null($filter) ) {
        if (!preg_match($filter, $dir)) continue;
      }
      if (is_dir($dir_path . '/' . $dir) ) array_push($list,$dir);
    }
    $dirs->close();
    return $list;
  }


  // 모듈 스키마 호출
  public static function getSchemasQueryString($module) {
    global $GV;
    $dir = $GV['PATH']['MODULES_PATH'] . "/{$module}/schemas";
    $schemas = FileSystem::getDirFiles($dir);

    $return = array();
    foreach($schemas as $schema) {
      if ( preg_match("/.sql$/i", $schema) ) { 
        array_push( $return, FileSystem::getReadFile($dir . '/' . $schema) );
      }
    }

    return $return;
  }

}
?>