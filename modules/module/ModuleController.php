<?php
/*
 @class ModuleController

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class ModuleController {

  /**
  * 키워드가 포함된 파라메터명을 찾아 배열로 리턴함. 배열인 경우 , 로 병합함
  *
  * @param string $keyword
  * @access private
  * @return arrary
  */
  private function _pick_param($keyword) {
    $ret = array();
    foreach(array_keys($_POST) as $name) {
      if (strpos($name,$keyword) > -1) {
        
        if (is_array($_POST[$name])) {
          $ret[$name] = implode(',',$_POST[$name]);
        } else {
          $ret[$name] = $_POST[$name];
        }

      }
    }

    return $ret;
  }

  /**
  * Module와 ModuleOptions 테이블에 데이터를 저장함
  *
  * @param  none
  * @access public
  * @return int module_orl
  */
  function procModuleInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    $args = array();
    $args['module_orl'] = _param('module_orl',NULL,'POST');
    $args['module'] = _param('module',NULL,'POST');
    $args['mid'] = _param('module_id',NULL,'POST');
    $args['module_title'] = _param('module_title',NULL,'POST');
    $args['browser_title'] = _param('browser_title',NULL,'POST');
    $args['skin'] = _param('skin',NULL,'POST');
    $args['layout_orl'] = _param('layout_orl','0','POST');
    $args['header_content'] = _param('header_content',NULL,'POST');
    $args['footer_content'] = _param('footer_content',NULL,'POST');

    try {
      $__Db->begin();
      
      // 멀티인 경우 MID 체크
      if ( $ModuleContext->getModConfig('SINGLE') == false) {
        // 모듈 명 필터 , 모듈 폴더에 존재하는 mid는 가질수 없음
        if ( !preg_match('/[a-zA-Z0-9-_]+/', $args['mid']) ) throw new Exception("사용할 수 없는 모듈명입니다.");
        if ( !ModuleDAO::isUniqueMid($args['mid'], $args['module_orl']) ) throw new Exception("사용할 수 없는 모듈명입니다.");
      }

      if ( empty($args['module_orl']) ) {
        $module_orl = ModuleDAO::insert($args);
      } else {
        $module_orl = $args['module_orl'];
        ModuleDAO::update($args);
      }

      ModuleOptionsDAO::del($module_orl);
      $options = $this->_pick_param('options_'); // array
      foreach(array_keys($options) as $name) {
        $args = array();
        $args['module_orl'] = $module_orl;
        $args['name'] = $name;
        $args['value'] = addslashes($options[$name]);
        ModuleOptionsDAO::insert($args);
      }

      // 캐쉬 파일 생성
      //ModuleObject::setCacheModuleOrl();
      $__Db->commit();

    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }


  /**
  * module_grant 테이블에 데이터를 저장함
  *
  * @param  none
  * @access public
  * @return none
  */
  function procModuleGrantInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    $module_orl = _param('module_orl',NULL,'POST');
    $access_privilege = _param('access_privilege',NULL,'POST');
    $list_privilege = _param('list_privilege',NULL,'POST');
    $view_privilege = _param('view_privilege',NULL,'POST');
    $write_privilege = _param('write_privilege',NULL,'POST');
    $comment_privilege = _param('comment_privilege',NULL,'POST');
    $manager_privilege = _param('manager_privilege',NULL,'POST');

    try {
      $__Db->begin();

      ModuleGrantDAO::del($module_orl);

      $args = array();
      $args['module_orl'] = $module_orl;
      $args['name'] = 'access';
      $args['group_orl'] = $access_privilege;
      ModuleGrantDAO::insert($args);

      $args['name'] = 'list';
      $args['group_orl'] = $list_privilege;
      ModuleGrantDAO::insert($args);

      $args['name'] = 'view';
      $args['group_orl'] = $view_privilege;
      ModuleGrantDAO::insert($args);

      $args['name'] = 'write';
      $args['group_orl'] = $write_privilege;
      ModuleGrantDAO::insert($args);

      $args['name'] = 'comment';
      $args['group_orl'] = $comment_privilege;
      ModuleGrantDAO::insert($args);

      $args['name'] = 'manager';
      $args['group_orl'] = $manager_privilege;
      ModuleGrantDAO::insert($args);

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }


  /**
  * Module와 ModuleOptions 테이블에 데이터를 삭제함
  *
  * @param  none
  * @access public
  * @return int module_orl
  */
  function procModuleDelete() {
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    $module_orl = _param('modulle_orl',NULL,'POST');

    try {
      $__Db->begin();

      if ( empty($module_orl) ) throw new Exception("필요한 정보가 없습니다.");
      
      ModuleDAO::del($module_orl);
      ModuleOptionsDAO::del($module_orl);

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

}

?>
