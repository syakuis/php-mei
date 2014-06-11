<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$GV['_FILE_UPLOADER_']['MODULE'] = 'file_uploader';
$GV['_FILE_UPLOADER_']['TITLE'] = '파일 업로드';
$GV['_FILE_UPLOADER_']['BRIEF'] = '파일 업로드 모듈입니다.';
$GV['_FILE_UPLOADER_']['SINGLE'] = true;

$GV['_FILE_UPLOADER_']['MODULE_PATH'] = $GV['PATH']['MODULES_PATH'] . '/' . $GV['_FILE_UPLOADER_']['MODULE'];
$GV['_FILE_UPLOADER_']['MODULE_R_PATH'] = $GV['PATH']['MODULES_R_PATH'] . '/' . $GV['_FILE_UPLOADER_']['MODULE'];
$GV['_FILE_UPLOADER_']['SKINS_PATH'] = $GV['_FILE_UPLOADER_']['MODULE_PATH'] . '/skins';
$GV['_FILE_UPLOADER_']['SKINS_R_PATH'] = $GV['_FILE_UPLOADER_']['MODULE_R_PATH'] . '/skins';

$GV['_FILE_UPLOADER_']['INCLUDE'] = false;
$GV['_FILE_UPLOADER_']['FILE_TYPE_FILTER'] = '*.php;*.js;*.html;*.htm;*.phps';

$GV['_FILE_UPLOADER_']['OPTIONS']['options_editor'] = 'smarteditor';
$GV['_FILE_UPLOADER_']['OPTIONS']['options_file_once_size'] = 10240; //KB
$GV['_FILE_UPLOADER_']['OPTIONS']['options_file_size'] = 10240;
$GV['_FILE_UPLOADER_']['OPTIONS']['options_file_type'] = '*.jpg';
$GV['_FILE_UPLOADER_']['OPTIONS']['options_file_limit'] = 5;

require_once "{$GV['_FILE_UPLOADER_']['MODULE_PATH']}/FileUploaderDAO.php";
require_once "{$GV['_FILE_UPLOADER_']['MODULE_PATH']}/FileUploaderObject.php";
?>
