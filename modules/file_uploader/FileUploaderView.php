<?php
/*
 @class FileUploaderView

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class FileUploaderView {

  function dispFileUploaderInsert() {
    $ModuleContext = ModuleContext::getInstance();
    $Context = Context::getInstance();
    $GV = $Context->getGV();
    $M = $Context->getM();
    $MOD = $ModuleContext->getMod();
    $ValueStack = ValueStack::getInstance();

    //if ( empty($GV['M']['module_orl']) || $GV['M']['seq'] < 0 ) return "[ERROR] FileUploaderView::dispFileUploaderInsert=>Null Point Exception";

    $module_orl = $ValueStack->get('file_uploader', 'module_orl');
    $seq = $ValueStack->get('file_uploader', 'seq');
    $target_orl = $ValueStack->get('file_uploader', 'target_orl');
    $sid = $Context->getSid();
    $file_upload_multi = $ValueStack->get('file_uploader', 'file_upload_multi');
    $upload_after_handler = $ValueStack->get('file_uploader', 'upload_after_handler');

    $ModuleContext->put('module_orl',$module_orl);
    $ModuleContext->put('seq',$seq);
    $ModuleContext->put('target_orl',$target_orl);
    $ModuleContext->put('sid',$sid);
    $ModuleContext->put('file_upload_multi',$file_upload_multi);
    $ModuleContext->put('upload_after_handler',$upload_after_handler);

    if ( empty($target_orl) ) { FileUploaderObject::deleteFileSid($module_orl, $seq, $sid); }

    $list = FileUploaderDAO::selectTargetOrl($module_orl, $seq, $sid, $target_orl);
    $ModuleContext->put('list',$list);

    if ($file_upload_multi != true) ModuleHandler::setSkinChange(NULL, 'file.multi.insert.php');
    return $ModuleContext;
  }

}

?>
