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
/*
        $ValueStack = ValueStack::getInstance();
        $ValueStack->put('comment', 'module_orl', 9);
        $ValueStack->put('comment', 'target_orl', 5);

        $comment_content = ModuleHandler::getModuleContent('module', 'comment', 'dispCommentList');
        $ModuleContext->put('comment_content',$comment_content);

        $ValueStack->put('comment', 'module_orl', 9);
        $ValueStack->put('comment', 'target_orl', 4);

        $comment_content = ModuleHandler::getModuleContent('module', 'comment', 'dispCommentList');
        $ModuleContext->put('comment_content2',$comment_content);
*/
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


