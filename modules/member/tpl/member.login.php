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

  // Input Clear
  var i_text = jQuery('.item>.i_label').next('.i_text');
  jQuery('.item>.i_label').css('position','absolute');
  i_text
    .focus(function(){
      jQuery(this).prev('.i_label').css('visibility','hidden');
    })
    .blur(function(){
      if(jQuery(this).val() == '') {
        jQuery(this).prev('.i_label').css('visibility','visible');
      } else {
        jQuery(this).prev('.i_label').css('visibility','hidden');
      }
    })
    .change(function(){
      if(jQuery(this).val() == ''){
        jQuery(this).prev('.i_label').css('visibility','visible');
      } else {
        jQuery(this).prev('.i_label').css('visibility','hidden');
      }
    })
    .blur();

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

<div class="sub_column_content">

  <div id="login" class="g_login">
    <form method="post" action="index.php" id="login_form" class="g_login">
      <fieldset>
        <legend>Login</legend>
        <div class="item">
          <label for="user_id" class="i_label">ID</label><input name="user_id" type="text" value="" id="user_id" class="i_text uid" />
        </div>
        <div class="item">
          <label for="password" class="i_label">PASSWORD</label><input name="password" type="password" value="" id="password" class="i_text upw" />
        </div>
        <p class="keeping"><input type="checkbox" value="Y" id="id_save" class="i_check" onclick="setUserId();" /><label for="id_save">아이디 기억</label></p>
        <span class="btn_login"><input type="button" value="로그인" onclick="form_login();" /></span>
        <ul class="help">
        <li class="first"><a href="/?module=member&act=dispMemberSignup">회원가입</a></li>
        <li><a href="/?module=member&act=dispMemberSearch">아이디/비밀번호 찾기</a></li>
        </ul>
      </fieldset>
    </form>
  </div>

</div>

<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.footer.php"; ?>