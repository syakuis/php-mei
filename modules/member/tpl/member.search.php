<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.header.php"; ?>

<script type="text/javascript">

function user_id_search() {

  jQuery('#form_userid').jaAction({
    filter : [
        { target : "#user_name", params : "&filter=notnull&title=이름" }
      , { target : "#email", params : "&filter=notnull&filter=email&title=이메일" }
    ],
    param : 'module=member&act=procMemberUserIdSearch',
    ajaxComplete : function(obj) {
      jQuery('#userid_search').text(obj.result.message);
    }
  });

}

function password_search() {

  jQuery('#form_password').jaAction({
    filter : [
        { target : "#user_name", params : "&filter=notnull&title=이름" }
      , { target : "#user_id", params : "&filter=notnull&title=아이디" }
      , { target : "#email", params : "&filter=notnull&filter=email&title=이메일" }
    ],
    param : 'module=member&act=procMemberPasswordSearch',
    ajaxComplete : function(obj) {
      jQuery('#password_search').text(obj.result.message);
    }
  });

}

</script>

<div class="clearfix">
<div style="width:40%;" class="pull-left">
<div class="panel panel-default">
  <div class="panel-body">계정 찾기</div>
  <div class="panel-footer">

    <form role="form" method="post" action="?" id="form_userid">
      <div class="form-group">
        <label for="user_name">이름</label>
        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="이름을 입력하세요.">
      </div>
      <div class="form-group">
        <label for="email">이메일</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="이메일을 입력하세요.">
      </div>
      <div class="form-group text-right"><button type="button" class="btn btn-success" onclick="user_id_search();" tabindex="3">아이디찾기</button></div>
      <div class="form-group">
        <div id="userid_search" class="alert alert-success"></div>
      </div>
    </form>

  </div>
</div>
</div>

<div style="width:40%;" class="pull-right">
<div class="panel panel-default">
  <div class="panel-body">암호 찾기</div>
  <div class="panel-footer">

    <form role="form" method="post" action="?" id="form_password">
      <div class="form-group">
        <label for="user_name">이름</label>
        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="이름을 입력하세요.">
      </div>
      <div class="form-group">
        <label for="user_id">아이디</label>
        <input type="text" class="form-control" id="user_id" name="user_id" placeholder="아이디를 입력하세요.">
      </div>
      <div class="form-group">
        <label for="email">이메일</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="이메일을 입력하세요.">
      </div>
      <div class="form-group text-right"><button type="button" class="btn btn-success" onclick="password_search();" tabindex="3">암호찾기</button></div>
      <div class="form-group">
        <div id="password_search" class="alert alert-success"></div>
      </div>
    </form>

  </div>
</div>
</div>
</div>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.footer.php"; ?>