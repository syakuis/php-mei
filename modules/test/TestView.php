<?php
/*
 @class DocumentView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/

class TestView {

  function dispTestList() {
    $Context = Context::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $ModuleContext->put('test','dispTestList');

    $oModuleContext = ModuleHandler::getModule('module','test','dispTestView');
    $__DisplayHandler = new DisplayHandler($oModuleContext);
    $content = $__DisplayHandler->getContent();
    $ModuleContext->put('content',$content);

    return $ModuleContext;
  }

  function dispTestView() {
    $Context = Context::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $ModuleContext->put('test','dispTestView');
    return $ModuleContext;
  }

}
/*
class TestView {

  function dispTestList() {
    $Context = Context::getInstance();
    $Context->put('test','dispTestList');

    $oContext = ModuleHandler::getModule('module','test','dispTestView');
    $__DisplayHandler = new DisplayHandler($oContext);
    $content = $__DisplayHandler->getContent();

    $Context->put('content',$content);
    return $Context;
  }

  function dispTestView() {
    $Context = Context::getInstance();
    $Context->put('test','dispTestView');
    return $Context;
  }

}*/


?>


