<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_INSTALL_']['MODULE'] = 'install';
$GV['_INSTALL_']['TITLE'] = '설치';
$GV['_INSTALL_']['BRIEF'] = '';
$GV['_INSTALL_']['SINGLE'] = true;

$GV['_INSTALL_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_INSTALL_']['MODULE'];
$GV['_INSTALL_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_INSTALL_']['MODULE'];

require_once "{$GV['_INSTALL_']['MODULE_PATH']}/InstallObject.php";
require_once "{$GV['_INSTALL_']['MODULE_PATH']}/InstallDAO.php";
?>