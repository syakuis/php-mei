<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_MESSAGE_']['MODULE'] = 'message';
$GV['_MESSAGE_']['TITLE'] = '메세지';
$GV['_MESSAGE_']['BRIEF'] = '모든 페이지의 결과 메세지를 출력합니다.';
$GV['_MESSAGE_']['SINGLE'] = true;

$GV['_MESSAGE_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_MESSAGE_']['MODULE'];
$GV['_MESSAGE_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_MESSAGE_']['MODULE'];
$GV['_MESSAGE_']['SKINS_PATH'] = "{$GV['_MESSAGE_']['MODULE_PATH']}/skins";
$GV['_MESSAGE_']['SKINS_R_PATH'] = "{$GV['_MESSAGE_']['MODULE_R_PATH']}/skins";
?>