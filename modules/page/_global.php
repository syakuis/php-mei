<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_PAGE_']['MODULE'] = 'page';
$GV['_PAGE_']['TITLE'] = '페이지';
$GV['_PAGE_']['BRIEF'] = '직접 화면을 꾸밀 수 있는 모듈입니다.';
$GV['_PAGE_']['SINGLE'] = false;

$GV['_PAGE_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_PAGE_']['MODULE'];
$GV['_PAGE_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_PAGE_']['MODULE'];
$GV['_PAGE_']['SKINS_PATH'] = "{$GV['_PAGE_']['MODULE_PATH']}/skins";
$GV['_PAGE_']['SKINS_R_PATH'] = "{$GV['_PAGE_']['MODULE_R_PATH']}/skins";
?>