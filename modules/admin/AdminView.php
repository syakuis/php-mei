<?php
/*
 @class AdminView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class AdminView {

  function dispAdminConfigInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();

    $module_orl = $ModuleContext->getMod('module_orl');
    if ( !empty($module_orl) ) $object = ModuleObject::getConfig($module_orl);
    $object = _extend($GV['_ADMIN_']['OPTIONS'],$object);

    $options_default_module = $object['options_default_module'];

    // module_orl 정보를 읽어옴
//    $module = ModuleObject::getCacheModuleOrl($options_default_module);
    $object['options_default_module_title'] = $module['module_title'];
    $ModuleContext->put('object',$object);

    return $ModuleContext;
  }

}