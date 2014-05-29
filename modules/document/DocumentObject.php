<?php
/*
 @class DocumentObject

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class DocumentObject {
  
  function commentCrud($document_orl,$del = false) {
    DocumentDAO::updateCommentCount($document_orl, $del);
  }

  function fileUploaderCrud($document_orl, $file_count) {
    DocumentDAO::updateFileCount($document_orl, $file_count);
  }

  function documentReadedUpdate($document_orl, $module_orl) {
    // 조회수 업데이트
    $document_readed_orl = $_COOKIE["document_readed_orl"];
    if (strpos($document_readed_orl,'||'.$document_orl) === false) {
      $document_readed_orl = "{$document_readed_orl}||{$document_orl}";
      setcookie("document_readed_orl", $document_readed_orl); 
      DocumentDAO::updateReadedCount($document_orl);
      self::documentReadedLogUpdate($document_orl,$module_orl); // 로그인 사용자만 로그에 남김
    }
  }

  function documentReadedLogUpdate($document_orl,$module_orl) {
    $member_orl = $_SESSION['_SESS_MEMBER_ORL'];
    $args = new stdClass();
    $args->document_orl = $document_orl;
    $args->module_orl = $module_orl;
    $args->member_orl = $member_orl;

    if (!empty($member_orl)) if ( DocumentReadedLogDAO::isUserReaded($document_orl, $member_orl) ) DocumentReadedLogDAO::insert($args);
  }


	function documentVotedLogUpdate($document_orl, $module_orl, $vote) {
    $member_orl = $_SESSION['_SESS_MEMBER_ORL'];
    $args = new stdClass();
    $args->document_orl = $document_orl;
    $args->module_orl = $module_orl;
    $args->vote = $vote;
		$args->member_orl = $member_orl;

    if ( !DocumentVotedLogDAO::isUserVoted($document_orl, $member_orl) && !empty($member_orl) ) {
      DocumentVotedLogDAO::insert($args);
      return true;
    }

    return false;
  }

}

?>
