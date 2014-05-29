<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.header.php"; ?>

<div class="page-header">
  <h1><span class="glyphicon glyphicon glyphicon-ok"></span> 설치 완료</h1>
</div>

<div class="bs-callout bs-callout-danger" id="create_table">
<h4>설치가 완료되었습니다.</h4>
<p>관리자 페이지로 이동하셔서 원하는 웹사이트를 만들어보세요.</p>
</div>

<p class="text-right"><a class="btn btn-success" href="./?module=admin" role="button"><span class="glyphicon glyphicon glyphicon-cog"></span> 관리자 페이지로 이동</a></p>

<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.footer.php"; ?>