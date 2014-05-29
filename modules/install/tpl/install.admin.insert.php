<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.header.php"; ?>


<script type="text/javascript">//<![CDATA[
function _goto() {

  jQuery('#form').jaAction({
    filter : [
      { target : "#user_id", params : "&filter=notnull&title=아이디" },
      { target : "#password", params : "&filter=notnull&title=비밀번호" },
      { target : "#user_name", params : "&filter=notnull&title=이름" },
      { target : "#nickname", params : "&filter=notnull&title=닉네임" },
      { target : "#email", params : "&filter=notnull&title=이메일" }
    ],
    param : 'module=install&act=procInstallAdminInsert',
    ask : 'save',
    afterSend : function() {
      location.href='./?module=install&act=dispInstallSuccess';
    }
  });

}

//]]></script>

<div class="page-header">
  <h1>관리자 등록</h1>
</div>

<form class="form-horizontal" role="form" id="form" method="post" action="?">
<div class="form-group">
  <label for="user_id" class="col-sm-2 control-label">아이디</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="user_id" name="user_id" value="" />
  </div>
</div>
<div class="form-group">
  <label for="password" class="col-sm-2 control-label">비밀번호</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="password" name="password" value="" />
  </div>
</div>
<div class="form-group">
  <label for="user_name" class="col-sm-2 control-label">이름</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="user_name" name="user_name" value="" />
  </div>
</div>
<div class="form-group">
  <label for="nickname" class="col-sm-2 control-label">닉네임</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="nickname" name="nickname" value="" />
  </div>
</div>
<div class="form-group">
  <label for="email" class="col-sm-2 control-label">이메일</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="email" name="email" value="" />
  </div>
</div>
</form>

<p class="text-right">
<p class="text-right"><button type="button" class="btn btn-success" onclick="_goto();"><span class="glyphicon glyphicon-ok"></span> 완료</button></p>

<?php include_once "{$GV['_INSTALL_']['MODULE_PATH']}/tpl/install.footer.php"; ?>