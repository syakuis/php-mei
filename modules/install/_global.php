<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_INSTALL_']['MODULE'] = 'install';
$GV['_INSTALL_']['TITLE'] = '설치';
$GV['_INSTALL_']['BRIEF'] = '모듈을 설치고 관리합니다.';
$GV['_INSTALL_']['VERSION'] = '0.1.0';
$GV['_INSTALL_']['SINGLE'] = true;

$GV['_INSTALL_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_INSTALL_']['MODULE'];
$GV['_INSTALL_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_INSTALL_']['MODULE'];

require_once "{$GV['_INSTALL_']['MODULE_PATH']}/InstallObject.php";
require_once "{$GV['_INSTALL_']['MODULE_PATH']}/InstallDAO.php";
?>