<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_COMMENT_']['MODULE'] = 'comment'; // 모듈 명
$GV['_COMMENT_']['TITLE'] = '댓글';
$GV['_COMMENT_']['BRIEF'] = '댓글 모듈입니다.';
$GV['_COMMENT_']['SINGLE'] = true; // 모듈 싱글 여부

$GV['_COMMENT_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_COMMENT_']['MODULE'];
$GV['_COMMENT_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_COMMENT_']['MODULE'];
$GV['_COMMENT_']['SKINS_PATH'] = $GV['_COMMENT_']['MODULE_PATH'] . '/skins';
$GV['_COMMENT_']['SKINS_R_PATH'] = $GV['_COMMENT_']['MODULE_R_PATH'] . '/skins';

$GV['_COMMENT_']['LIST_COUNT'] = 2; // 목록 수
$GV['_COMMENT_']['PAGE_COUNT'] = 3; // 페이지 수

array_push($GV['JS'],"{$GV['_COMMENT_']['MODULE_R_PATH']}/js/comment.js");

require_once "{$GV['_COMMENT_']['MODULE_PATH']}/CommentDAO.php";
require_once "{$GV['_COMMENT_']['MODULE_PATH']}/CommentVotedLogDAO.php";
require_once "{$GV['_COMMENT_']['MODULE_PATH']}/CommentObject.php";
?>