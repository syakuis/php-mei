<?php
/*
 @class DocumentController

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class DocumentController {

  /**
  * Module와 ModuleOptions 테이블에 데이터를 저장함
  *
  * @param  none
  * @access public
  * @return int module_orl
  */
  function procDocumentInsert() {
    $Context = Context::getInstance();
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();
    
    $module_orl = $ModuleContext->getMod('module_orl');
    $seq = '0';
    $sid = $Context->getSid();

    if (!$Context->getGrant('GRANT_WRITE')) $M->resultError("권한이 없습니다.");

    $args = array();
    $args['module_orl'] = $module_orl;

    $args['document_orl'] = _post('document_orl');
    $document_orl = $args['document_orl'];
    $args['is_notice'] = _param('is_notice','N','POST');
    $args['is_bold'] = _param('is_bold','N','POST');

    $args['color'] = _post('color');
    $args['style'] = _post('style');
    $args['subject'] = _post('subject');
    $args['content'] = _post('content');
    $args['content_text'] = _nude_html($args['content']);
    $args['is_mobile'] = ($Context->getIsMobile) ? 'Y' : 'N';

    try {
      $__Db->begin();

      if ( empty($document_orl) ) {
        $file_count = FileUploaderDAO::getFileCount($module_orl, $seq, $sid, $document_orl); // 파일 클래스 사용
        $args['file_count'] = $file_count;
        $document_orl = DocumentDAO::insert($args);
        FileUploaderDAO::updateSid($module_orl, $seq, $sid, $document_orl); // 파일 클래스 사용

      } else {

        $rs = DocumentDAO::selectOne($document_orl);
        if ($rs['member_orl'] != $_SESSION['_SESS_MEMBER_ORL']) throw new Exception("권한이 없습니다.");
        DocumentDAO::update($args);
      }

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  function procDocumentDelete() {
    $Context = Context::getInstance();
    $GRANT = $Context->getGrant();
    $ModuleContext = ModuleContext::getInstance();
    $__Db = Db::getInstance();

    if (!$GRANT['GRANT_WRITE']) $ModuleContext->resultError("권한이 없습니다.");

    $module_orl = $ModuleContext->getMod('module_orl');
    $seq = '0';
    $document_orl = _post('document_orl');

    try {
      $__Db->begin();

      $rs = DocumentDAO::selectOne($document_orl);
      if ($rs['member_orl'] != $_SESSION['_SESS_MEMBER_ORL']) $ModuleContext->resultError("권한이 없습니다.");

      DocumentDAO::delOne($document_orl);
      // 파일삭제
      FileUploaderObject::deleteFile($module_orl,$seq, $document_orl);
      // 댓글 삭제
      CommentObject::deleteTargetOrl($module_orl,  $document_orl);
      // 게시물 로그 삭제
      DocumentVotedLog::del($document_orl);
      DocumentReadedLog::del($document_orl);

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  function procDocumentVotedUpdate() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();

    $document_orl = _post('document_orl');
    $module_orl = $ModuleContext->getMod('module_orl');
    $type = _post('type');
    $voted = ($type == 'good') ? 1 : -1;
    $voted_text = ($type == 'good') ? '추천' : '비추';

    try {
      $__Db->begin();

      if(DocumentObject::documentVotedLogUpdate($document_orl, $module_orl, $voted)) {
        $ModuleContext->setMessage("{$voted_text}하였습니다.");
        if ($type == 'good') DocumentDAO::updateGoodCount($document_orl);
        if ($type == 'bad') DocumentDAO::updateBadCount($document_orl);

      } else {
        $ModuleContext->setMessage("중복 {$voted_text}할 수 없습니다.");
        $ModuleContext->setError(TRUE);
      }

      $__Db->commit();
    } catch(Exception $e) {
      $__Db->rollback();
      throw new Exception($e);
    }

    return $ModuleContext;
  }

  function procDocumentAdminDelete() {
    $__Db = Db::getInstance();
    $ModuleContext = ModuleContext::getInstance();

    // 게시물 삭제
    // 게시물 로그 삭제
    // 파일 삭제
    // 댓글 삭제
    // 모듈삭제
    // 모듈 옵션 삭제
    // 모듈 권한 삭제

    return $ModuleContext;

  }

}

?>