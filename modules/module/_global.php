<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_MODULE_']['MODULE'] = 'module';
$GV['_MODULE_']['MODULE_TITLE'] = '모듈';
$GV['_MODULE_']['SINGLE'] = false;
$GV['_MODULE_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/module';
$GV['_MODULE_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/module';

array_push($GV['JS'],"{$GV['_MODULE_']['MODULE_R_PATH']}/js/module.js");

require_once "{$GV['_MODULE_']['MODULE_PATH']}/ModuleDAO.php";
require_once "{$GV['_MODULE_']['MODULE_PATH']}/ModuleOptionsDAO.php";
require_once "{$GV['_MODULE_']['MODULE_PATH']}/ModuleGrantDAO.php";

require_once "{$GV['_MODULE_']['MODULE_PATH']}/ModuleObject.php";
?>