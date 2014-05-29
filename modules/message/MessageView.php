<?php
/*
 @class MessageView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class MessageView {

  function dispMessageView() {
    $ModuleContext = ModuleContext::getInstance();
    return $ModuleContext;
  }

  function dispMessageAdminConfigInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();

    $module_orl = $ModuleContext->getMod('module_orl');
    if ( !empty($module_orl) ) {
      $object = ModuleObject::getConfig($module_orl);
    }
    $skin_list = ModuleHandler::getSkinList($GV['_MESSAGE_']['SKINS_PATH']);
    $ModuleContext->put('object',$object);
    $ModuleContext->put('skin_list',$skin_list);

    return $ModuleContext;
  }

}

?>
