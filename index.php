<?php 
define("__SYAKU__", TRUE);
include_once "./config.php";

if(!get_magic_quotes_gpc())
{
  if (is_array($_GET))
    foreach($_GET as $_tmp['k'] => $_tmp['v'])
      if (is_array($_GET[$_tmp['k']]))
        foreach($_GET[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) 
          $_GET[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']); 
      else $_GET[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
  if (is_array($_POST))
    foreach($_POST as $_tmp['k'] => $_tmp['v'])
      if (is_array($_POST[$_tmp['k']]))
        foreach($_POST[$_tmp['k']] as $_tmp['k1'] => $_tmp['v1']) 
          $_POST[$_tmp['k']][$_tmp['k1']] = ${$_tmp['k']}[$_tmp['k1']] = addslashes($_tmp['v1']);
      else $_POST[$_tmp['k']] = ${$_tmp['k']} = addslashes($_tmp['v']);
}
else {
  if (!ini_get('register_globals'))
  {
    extract($_GET);
    extract($_POST);
  }
}

$Context = Context::getInstance(TRUE);
$ModuleContext = ModuleContext::getInstance(TRUE);

try {

  $Context->init();
  // 모듈 호출

  $mid = $Context->getMid();
  $module = $Context->getModule();
  $act = $Context->getAct();

  // 호출 모듈 선정.
  $kind = ModuleHandler::getFistModule($mid, $module);

  ModuleHandler::getModuleInstance($kind, ${$kind}, $act);

} catch(Exception $e) {
  $ModuleContext->setError(TRUE);
  $ModuleContext->setMessage($e->getMessage());
}

// 출력
$__DisplayHandler = new DisplayHandler($ModuleContext);
echo $__DisplayHandler->getContent(FALSE, FALSE);
$Context->close();
?>