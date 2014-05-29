<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_MEMBER_']['MODULE'] = 'member';
$GV['_MEMBER_']['TITLE'] = '회원';
$GV['_MEMBER_']['BRIEF'] = '회원을 관리하는 모듈입니다.';
$GV['_MEMBER_']['SINGLE'] = true;

$GV['_MEMBER_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_MEMBER_']['MODULE'];
$GV['_MEMBER_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_MEMBER_']['MODULE'];
$GV['_MEMBER_']['SKINS_PATH'] = "{$GV['_MEMBER_']['MODULE_PATH']}/skins";
$GV['_MEMBER_']['SKINS_R_PATH'] = "{$GV['_MEMBER_']['MODULE_R_PATH']}/skins";

array_push($GV['JS'],"{$GV['_MEMBER_']['MODULE_R_PATH']}/js/member.js");

require_once "{$GV['_MEMBER_']['MODULE_PATH']}/MemberDAO.php";
require_once "{$GV['_MEMBER_']['MODULE_PATH']}/MemberOutDAO.php";
require_once "{$GV['_MEMBER_']['MODULE_PATH']}/LoginDAO.php";
require_once "{$GV['_MEMBER_']['MODULE_PATH']}/MemberObject.php";
?>