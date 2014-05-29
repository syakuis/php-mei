<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_ADMIN_']['MODULE'] = 'admin';
$GV['_ADMIN_']['TITLE'] = '관리자';
$GV['_ADMIN_']['BRIEF'] = '기본설정 정보를 관리하는 모듈입니다.';
$GV['_ADMIN_']['SINGLE'] = true;

$GV['_ADMIN_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_ADMIN_']['MODULE'];
$GV['_ADMIN_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_ADMIN_']['MODULE'];

$GV['_ADMIN_']['OPTIONS']['options_mobile_target'] = 'iphone,lgtelecom,skt,mobile,samsung,nokia,blackberry,android,android,sony,phone';
?>