<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_TEST2_']['MODULE'] = 'test2';
$GV['_TEST2_']['TITLE'] = '테스트2';
$GV['_TEST2_']['BRIEF'] = '설치 테스트용 모듈입니다.';
$GV['_TEST2_']['SINGLE'] = true;

$GV['_TEST2_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_TEST2_']['MODULE'];
$GV['_TEST2_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_TEST2_']['MODULE'];
$GV['_TEST2_']['SKINS_PATH'] = $GV['_TEST2_']['MODULE_PATH'] . '/skins';
$GV['_TEST2_']['SKINS_R_PATH'] = $GV['_TEST2_']['MODULE_R_PATH'] . '/skins';
?>