<?php if (!defined("__SYAKU__")) exit; ?>
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
      location.href="<?php echo _param('ret_url')?>";
    }
  });
}

//]]>
</script>
<link href="<?php echo $GV['_LAYOUT_ADMIN_']['LAYOUT_R_PATH']?>/css/signin.css" rel="stylesheet">
<form class="form-signin" role="form" method="post" action="index.php" id="login_form" class="g_login">
  <h2 class="form-signin-heading">관리자 로그인</h2>
  <input type="text" id="user_id" name="user_id" class="form-control" placeholder="아이디" required autofocus>
  <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호" required>
  <label class="checkbox">
    <input type="checkbox" id="id_save" value="Y" onclick="setUserId();"> 아이디 기억
  </label>
  <button class="btn btn-lg btn-primary btn-block" type="button" onclick="form_login();">로그인</button>
</form>