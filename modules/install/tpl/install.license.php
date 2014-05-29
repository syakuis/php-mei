<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.header.php"; ?>

<div class="page-header">
  <h1>라이센스</h1>
</div>

<p><textarea class="form-control" rows="10"></textarea></p>
<p class="text-right"><a class="btn btn-success" href="./?module=install&act=dispInstallPrepare" role="button"><span class="glyphicon glyphicon-ok"></span> 라이센스에 동의합니다.</a></p>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.footer.php"; ?>