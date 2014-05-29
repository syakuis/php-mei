<?php
/*
 @class ModuleObject

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class ModuleObject {
  function insertInstall($MOD, $args,$options = NULL) {
    $module_orl = 0;

    if ($MOD['SINGLE'] == TRUE) {
      $rs = ModuleDAO::selectOne($args['module'], 'module');
      if ($rs) return $rs['module_orl'];
    }

    $module_orl = ModuleDAO::insert($args);

    if ( !empty($module_orl) && !is_null($options) ) {

      ModuleOptionsDAO::del($module_orl);

      foreach($options as $k => $v) {
        $args = array();
        $args['module_orl'] = $module_orl;
        $args['name'] = $k;
        $args['value'] = addslashes($v);
        ModuleOptionsDAO::insert($args);
      }

    }

    // 캐쉬 파일 생성
    //self::setCacheModuleOrl();

    return $module_orl;
  }

  function getList($module = NULL) {
    $GV = $GLOBALS['GV'];

    $V = array();
    $V['pages'] = _page_index( ModuleDAO::getCount($module), $GV['PAGE'], $GV['PAGE_ROW'], $GV['PAGE_LINK'] );
    $V['list'] = ModuleDAO::select($module, $V['pages']['start_idx'], $V['pages']['page_row']);

    return $V;
  }

  /**
  * 모듈과 모듈 옵션 정보를 수집하여 반환함
  *
  * @param int module_orl or string mid
  * @return array
  */
  function getConfig($val, $kind = NULL) {
    if ( empty($val) ) return NULL;

    $object = ModuleDAO::selectOne($val,$kind);
    if ($object == NULL) return NULL;

    $options = ModuleOptionsDAO::select($object['module_orl']);
    foreach($options as $rs) {
      $object[$rs['name']] = $rs['value'];
    }
    
    return $object;
  }

  function getGrant($module_orl) {
    if ( empty($module_orl) ) return NULL;
    $result = ModuleGrantDAO::select($module_orl);
    if (!$result) return NULL;
    foreach($result as $rs) {
      $object[$rs['name']] = $rs['group_orl'];
    }
    return $object;
  }

}