<?php
/*
 @class InstallController

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class InstallController {

  // 폴더생성
  private function createFolder($path) {
    $success = false;
    if ( !file_exists($path) ) {
      if ( mkdir($path, 0757) ) $success = true;
    } else {
      if ( @chmod($path, 0757) ) $success = true;
    }

    return $success;
  }

  // 인스톨 준비 서버환경 체크 및 폴더 생성
  function procInstallPrepare() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();

    $_php_success = (version_compare(phpversion(), '5.3.0') >= 0);
    $_data_grant_success = true;
    $_data_success = true;

    // 폴더 생성 및 권한 체크
    $data = $GV['PATH']['DATA_PATH'];
    if ( file_exists($data) ) {

      if ( !is_writable($data) ) {
        // chmod 변경
        if ( !@chmod($data, 0757) ) { $_data_grant_success = false; }
      }

    } else {
      // 폴더 생성
      if ( !mkdir($data, 0757) ) { $_data_success = false; }
    }

    if ( file_exists($data) && $_data_success == true ) {
      // 그외 폴더 생성 files cache config session
      $files_path = $data . '/files';
      $_data_files_success = $this->createFolder($files_path);
      $cache_path = $data . '/cache';
      $_data_cache_success = $this->createFolder($cache_path);
      $config_path = $data . '/config';
      $_data_config_success = $this->createFolder($config_path);
      $session_path = $data . '/session';
      $_data_session_success = $this->createFolder($session_path);

    }

    $success = ($_php_success == true && $_data_grant_success == true && $_data_success == true && $_data_files_success == true && $_data_cache_success == true && $_data_config_success == true && $_data_session_success == true);

    if ($success) {
      // 모듈 수집
    }

    $ModuleContext->put('success', $success);
    $ModuleContext->put('php', $_php_success);
    $ModuleContext->put('grant', $_data_grant_success);
    $ModuleContext->put('data_folder', $_data_success);
    $ModuleContext->put('files_folder', $_data_files_success);
    $ModuleContext->put('cache_folder', $_data_cache_success);
    $ModuleContext->put('config_folder', $_data_config_success);
    $ModuleContext->put('session_folder', $_data_session_success);

    return $ModuleContext;
  }

  // 디비 설정
  function procInstallDbSetting() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();

    $db_host = _post('db_host');
    $db_post = _post('db_post');
    $db_username = _post('db_username');
    $db_password = _post('db_password');
    $db_database = _post('db_database');

    $__Db = new MySQL($db_host,$db_username,$db_password,$db_database);

    $buffer = '<?php if (!defined(\'__SYAKU__\')) exit; ' . PHP_EOL;
    $buffer .= '$db_host = \'' . $db_host . '\';' . PHP_EOL;
    $buffer .= '$db_post = \'' . $db_post . '\';' . PHP_EOL;
    $buffer .= '$db_username = \'' . $db_username . '\';' . PHP_EOL;
    $buffer .= '$db_password = \'' . $db_password . '\';' . PHP_EOL;
    $buffer .= '$db_database = \'' . $db_database . '\'; ?>' . PHP_EOL;

    if (!FileSystem::writeFile($Context->getPath('DATA_PATH') . '/config/db.php',$buffer)) throw new Exception("파일 생성 실패");

    return $ModuleContext;
  }

  // 디비 테이블 생성
  function procInstallCreateTable() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    // 모듈명
    $modules = ModuleHandler::getModuleNames();

    // 테이블 생성
    foreach($modules as $module) {
      $schemas = ModuleHandler::getSchemasQueryString($module);

      foreach($schemas as $schema) {
        $__Db->query = $schema;
        $__Db->statement();
      }
    }

    return $ModuleContext;
  }

  // 모듈 설치
  function procInstallModule() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();
    $__Db = Db::getInstance();

    try {
      $__Db->begin();

      $other_install = array();

      $modules = ModuleHandler::getModuleNames();
      foreach($modules as $module) {
        $success = false;

        // 설치여부 체크
        $cond = array( 'module' => $module );
        $install_rs = InstallDAO::selectOne($cond);

        if ($install_rs && $install_rs['status'] == 'Y') continue;

        // 설치 모듈 검색
        $module_gv = $GV[ModuleHandler::getGVName($module)];
        $module_path = $module_gv['MODULE_PATH'] . "/{$module}.install.php";
        if ( file_exists($module_path) ) require_once $module_path;

        // 모듈 설치 호출
        $module_class = $module . 'Install';
        if ( class_exists($module_class) ) {
          // 클래스 선언
          $func = create_function('', "return new {$module_class}();");
          $cls = $func();
          if( is_object($cls) ) {
            if ( method_exists($cls,'moduleInstall') ) {
              $success = $cls->moduleInstall();
            }
          }
        } else {
          array_push($other_install,$module);
        }

        if ($success) {
          $args = array();
          $args['module'] = $module;
          $args['status'] = 'Y';
          $args['reg_datetime'] = _date();
          InstallObject::saveInstall($args);
        }

      } // 모듈 설치 끝

      // 설치 모듈이 없는 경우 자동 설치
      foreach($other_install as $module) {
        $name = ModuleHandler::getGVName($module);

        // 모듈 설치 ( 싱글인 경우)
        if ($GV[$name]['SINGLE'] == true) {
          $args = array();
          $args['module'] = $GV[$name]['MODULE'];
          $args['module_title'] = $GV[$name]['TITLE'];
          $args['browser_title'] = $GV[$name]['TITLE'];
          $args['locking'] = 'Y';
          ModuleObject::insertInstall($GV[$name], $args, $GV[$name]['OPTIONS']);
        }

        $args = array();
        $args['module'] = $module;
        $args['status'] = 'Y';
        $args['reg_datetime'] = _date();
        InstallObject::saveInstall($args);
      }

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  // 관리자 등록
  function procInstallUserAdminInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    $user_id = _post('user_id');
    $user_name = _post('user_name');
    $nickname = _post('nickname');
    $email = _post('email');
    $password = _post('password');
    $is_admin = 'Y';
    
    $args = array();
    $args['user_name'] = $user_name;
    $args['nickname'] = $nickname;
    $args['email'] = $email;
    $args['password'] = md5($password);
    $args['is_admin'] = $is_admin;

    $rs = MemberDAO::selectOne($user_id, 'user_id');
    if (!$rs) {
      $args['user_id'] = $user_id;
      MemberDAO::insert($args);
    } else {
      MemberDAO::update($args,$rs['member_orl']);
    }

    return $ModuleContext;
  }

}

?>
