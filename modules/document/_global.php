<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_DOCUMENT_']['MODULE'] = 'document';
$GV['_DOCUMENT_']['TITLE'] = '문서';
$GV['_DOCUMENT_']['BRIEF'] = '문서를 관리하는 모듈입니다.';
$GV['_DOCUMENT_']['SINGLE'] = false;

$GV['_DOCUMENT_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_DOCUMENT_']['MODULE'];
$GV['_DOCUMENT_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_DOCUMENT_']['MODULE'];
$GV['_DOCUMENT_']['SKINS_PATH'] = $GV['_DOCUMENT_']['MODULE_PATH'] . '/skins';
$GV['_DOCUMENT_']['SKINS_R_PATH'] = $GV['_DOCUMENT_']['MODULE_R_PATH'] . '/skins';

$GV['_DOCUMENT_']['OPTIONS']['options_list_count'] = 20; // 목록 수
$GV['_DOCUMENT_']['OPTIONS']['options_page_count'] = 10; // 페이지 수
$GV['_DOCUMENT_']['OPTIONS']['options_input_height'] = '200'; // 입력 상자 높이
$GV['_DOCUMENT_']['OPTIONS']['options_comment_list_count'] = 20; // 목록 수
$GV['_DOCUMENT_']['OPTIONS']['options_comment_page_count'] = 10; // 페이지 수


require_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/DocumentDAO.php";
require_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/DocumentReadedLogDAO.php";
require_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/DocumentVotedLogDAO.php";
require_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/DocumentObject.php";
?>