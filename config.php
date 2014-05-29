<?php if (!defined("__SYAKU__")) exit; ?>
<?php
if(version_compare(PHP_VERSION, '5.4.0', '<')) {
	@error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
} else {
	@error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
}
ini_set("display_errors", 1);

if(version_compare(PHP_VERSION, '5.3.0') >= 0) {
	date_default_timezone_set(@date_default_timezone_get());
}

define('_MEI_VERSION_', '1.0.0');
define('_ROOT_PATH_', dirname(__FILE__));
define('_MEI_R_PATH_', preg_replace("/\/[^\/]*\.php$/", '', $_SERVER['PHP_SELF']));
define('_MEI_PATH_', _ROOT_PATH_ . _MEI_R_PATH_);

$GV = array();
$GV['PATH'] = array(
  'CLASSES_PATH' => _MEI_PATH_ . '/classes',
  'LIB_PATH' => _MEI_PATH_ . '/lib',
  'MODULES_R_PATH' => _MEI_R_PATH_ . '/modules',
  'MODULES_PATH' => _MEI_PATH_ . '/modules',
  'LAYOUTS_R_PATH' => _MEI_R_PATH_ . '/layouts',
  'LAYOUTS_PATH' => _MEI_PATH_ . '/layouts',
  'COMMONS_R_PATH' => _MEI_R_PATH_ . '/commons',
  'ADDONS_PATH' => _MEI_PATH_ . '/addons',
  'ADDONS_R_PATH' => _MEI_R_PATH_ . '/addons',
  'IMAGES_R_PATH' => _MEI_R_PATH_ . '/images',
  'DATA_R_PATH' => _MEI_R_PATH_ . '/data',
  'DATA_PATH' => _MEI_PATH_ . '/data'
);

$GV['PATH']['FILES_R_PATH'] = $GV['PATH']['DATA_R_PATH'] . '/files';
$GV['PATH']['FILES_PATH'] = $GV['PATH']['DATA_PATH'] . '/files';

$GV['CSS'] = array();
$GV['JS'] = array();

require_once $GV['PATH']['LIB_PATH'] . "/Commons.func.php";

require_once $GV['PATH']['CLASSES_PATH'] . "/Mysql.class.php";
require_once $GV['PATH']['CLASSES_PATH'] . "/Db.class.php";
require_once $GV['PATH']['CLASSES_PATH'] . "/FileSystem.class.php";
require_once $GV['PATH']['CLASSES_PATH'] . "/ValueStack.class.php";

require_once $GV['PATH']['CLASSES_PATH'] . "/AddonHandler.class.php";
require_once $GV['PATH']['CLASSES_PATH'] . "/InterceptorHandler.class.php";

require_once $GV['PATH']['CLASSES_PATH'] . "/Context.class.php";
require_once $GV['PATH']['CLASSES_PATH'] . "/ModuleContext.class.php";
require_once $GV['PATH']['CLASSES_PATH'] . "/ModuleHandler.class.php";
require_once $GV['PATH']['CLASSES_PATH'] . "/DisplayHandler.class.php";

$GV['PAGE'] = _param('page');
$GV['PAGE_ROW'] = 20;
$GV['PAGE_LINK'] = 10;
?>
