<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.header.php"; ?>
<script type="text/javascript">
//<![CDATA[

// init
jQuery(function() {
  jQuery('#login_form').keydown(function(evt) {
    if (evt.keyCode == 13) { form_login(); }
  });

  // 계정 저장 쿠키 처리
  var data = eval(jQuery.ja.getCookie("_id_save_"));
  if (!jQuery.ja.isEmpty(data)) {
    var tid = data.user_id;

    if (tid != "" && tid != null) {
      jQuery("#login_form #user_id").val(tid);
      jQuery.ja.setValue("#login_form #id_save",'Y');
    }
  }

  jQuery("#login_form #user_id").keydown(function() {
    setUserId();
  });

});

// 계정 쿠키에 저장
function setUserId() {
  var check = jQuery("#login_form #id_save");
  var tid = jQuery("#login_form #user_id").val();
  tid = tid.replace("아이디","");

  if (check.attr("checked") == true && tid != "") {
    // json 을 문자열로 저장한다.
    var value = "({" +
      "user_id : '" + tid + "' " +
    "})";

    jQuery.ja.setCookie("_id_save_",value,30,"/");
  } else {
    jQuery.ja.setCookie("_id_save_","");
  }
}

function form_login() {
  jQuery('#login_form').jaAction({ 
    filter : [
        { target : "#user_id", params : "&filter=notnull&title=아이디" }
      , { target : "#password", params : "&filter=notnull&title=비밀번호" }
    ],
    param : 'module=member&act=procMemberLogin',
    loading : false,
    afterSend : function() {
      location.href="<?php echo $ret_url?>";
    }
  });
}

//]]>
</script>

<div style="width:40%;margin:0 auto;">
<div class="panel panel-default">
  <div class="panel-body">Sign In</div>
  <div class="panel-footer">

    <form role="form" method="post" action="?" id="login_form">
      <div class="form-group">
        <label for="user_id">ID</label>
        <div class="input-group">
          <input type="text" class="form-control" id="user_id" name="user_id" placeholder="아이디를 입력하세요." tabindex="1">
          <span class="input-group-btn"><a class="btn btn-default" href="./<?php echo _param_get('act=dispMemberSignup','?')?>" role="button">회원가입</a></span>
        </div>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" placeholder="비밀번호를 입력하세요." tabindex="2">
          <span class="input-group-btn"><a class="btn btn-default" href="./<?php echo _param_get('act=dispMemberSearch','?')?>" role="button">암호찾기</a></span>
        </div>
      </div>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="Y" id="id_save" onclick="setUserId();"> 아이디 기억
        </label>
      </div>
      <div class="text-right"><button type="button" class="btn btn-success btn-lg" onclick="form_login();" tabindex="3">로그인</button></div>
    </form>

  </div>
</div>
</div>

<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.footer.php"; ?>