<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_LAYOUT_']['MODULE'] = 'layout';
$GV['_LAYOUT_']['TITLE'] = '레이아웃';
$GV['_LAYOUT_']['BRIEF'] = '모듈에 사용되는 레이아웃을 관리합니다.';
$GV['_LAYOUT_']['SINGLE'] = true;

$GV['_LAYOUT_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/layout';
$GV['_LAYOUT_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/layout';

require_once "{$GV['_LAYOUT_']['MODULE_PATH']}/LayoutDAO.php";
require_once "{$GV['_LAYOUT_']['MODULE_PATH']}/LayoutObject.php";
?>