<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_TEST_']['MODULE'] = 'test';
$GV['_TEST_']['TITLE'] = '테스트';
$GV['_TEST_']['BRIEF'] = '테스트 모듈입니다.';
$GV['_TEST_']['SINGLE'] = true;

$GV['_TEST_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_TEST_']['MODULE'];
$GV['_TEST_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_TEST_']['MODULE'];
$GV['_TEST_']['SKINS_PATH'] = $GV['_TEST_']['MODULE_PATH'] . '/skins';
$GV['_TEST_']['SKINS_R_PATH'] = $GV['_TEST_']['MODULE_R_PATH'] . '/skins';
?>