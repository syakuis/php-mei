<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.header.php"; ?>


<script type="text/javascript">//<![CDATA[
function _goto() {

  jQuery('#form').jaAction({
    filter : [
      { target : "#db_host", params : "&filter=notnull&title=호스트" },
      { target : "#db_post", params : "&filter=notnull&filter=number&title=포트" },
      { target : "#db_username", params : "&filter=notnull&title=계정" },
      { target : "#db_password", params : "&filter=notnull&title=암호" },
      { target : "#db_database", params : "&filter=notnull&title=디비" }
    ],
    param : 'module=install&act=procInstallDbSetting',
    ask : 'execute',
    afterSend : function() {
      location.href='./?module=install&act=dispInstallStatus';
    }
  });

}

//]]></script>

<div class="page-header">
  <h1>MySQL 접속 정보</h1>
</div>

<form class="form-horizontal" role="form" id="form" method="post" action="?">
<div class="form-group">
  <label for="db_host" class="col-sm-2 control-label">호스트</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="db_host" name="db_host" value="localhost" placeholder="접속 경로를 입력하세요. (기본 : localhost)" />
  </div>
</div>
<div class="form-group">
  <label for="db_post" class="col-sm-2 control-label">포트</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="db_post" name="db_post" value="3306" placeholder="접속 포트를 입력하세요. (기본 : 3306)" />
  </div>
</div>
<div class="form-group">
  <label for="db_username" class="col-sm-2 control-label">계정</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="db_username" name="db_username" value="" placeholder="접속 계정을 입력하세요." />
  </div>
</div>
<div class="form-group">
  <label for="db_password" class="col-sm-2 control-label">암호</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="db_password" name="db_password" value="" placeholder="접속 압호를 입력하세요." />
  </div>
</div>
<div class="form-group">
  <label for="db_database" class="col-sm-2 control-label">디비</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="db_database" name="db_database" value="" placeholder="접속 디비명을 입력하세요." />
  </div>
</div>
</form>

<p class="text-right">
<p class="text-right"><button type="button" class="btn btn-success" onclick="_goto();"><span class="glyphicon glyphicon-share-alt"></span> 다음</button></p>

<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.footer.php"; ?>