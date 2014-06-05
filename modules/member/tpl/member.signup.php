<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.header.php"; ?>

<script type="text/javascript">

jQuery.jaFilter.setDefaults({ message : filter_message });

// jaAction 필터데이터
var filter_data = [
  { target : "#user_id", params : "&filter=notnull&filter=user_id&length=6,15&title=아이디" } , 
  { target : "#email", params : "&filter=notnull&filter=email&title=이메일" } , 
  { target : "#user_name", params : "&filter=notnull&filter=user_name&length=2,10&title=이름" } , 
  { target : "#nickname", params : "&filter=notnull&filter=nickname&length=2,10&title=닉네임" } , 
  { target : "#password", params : "&filter=notnull&length=6,16&title=비밀번호" }

];

jQuery(function() {

  jQuery('#form').keydown(function(evt) {
    if (evt.keyCode == 13) { form_save(); }
  });

  // 중복 값 체크
  jQuery.member.user_name_regx(/^[a-zA-Z가-힣]*$/);
  jQuery.member.user_id_regx(/^[a-z]+([_0-9a-z]+)*$/);
  jQuery.member.repeat_check('user_id',filter_message);
  jQuery.member.nickname_regx(/^[a-zA-Z가-힣0-9]*$/);
  jQuery.member.repeat_check('nickname',filter_message);
  jQuery.member.repeat_check('email',filter_message);

});

// 중복체크 및 유효성 검사 메세지 출력
function filter_message(data) {
  data.target.next('p').remove();
  var o = jQuery("<p class='i_dsc'></p>").text( data.message );
  if (data.error) { o.css('color','red'); data.target.focus(); }
  data.target.after(o.fadeIn(1).delay(2000).fadeOut(1000));
}

function form_save() {

  jQuery('#form').jaAction({
    filter : filter_data,
    ask_msg : '회원가입하시겠습니까?' , 
    param : 'module=member&act=procMemberSignup',
    redirect : '/',
    beforeAction : function() {
      jQuery("#form #user_id2").val(jQuery("#form #user_id").val());
      jQuery("#form #nicckname2").val(jQuery("#form #nicckname").val());
      jQuery("#form #email2").val(jQuery("#form #email").val());
    }
  });

}

</script>

<div style="width:40%;margin:0 auto;">
<div class="well">
이메일 주소는 계정과 암호를 분실했을 때 찾을 수 있는 유일한 방법입니다. 정확하게 입력하세요.
</div>

<form role="form" action="?" method="post" id="form">
<input type="hidden" id="member_orl" name="member_orl" value="" />
  <div class="form-group">
    <label for="user_id">아이디</label>
    <input type="hidden" id="user_id2" name="user_id2" value="" />
    <input type="text" class="form-control" id="user_id" name="user_id" maxlength="15" placeholder="아이디를 입력하세요.">
  </div>
  <div class="form-group">
    <label for="email">메일주소</label>
    <input type="hidden" id="email2" name="email2" value="" />
    <input type="text" class="form-control" id="email" name="email" placeholder="메일주소를 입력하세요.">
  </div>
  <div class="form-group">
    <label for="user_name">이름</label>
    <input type="text" class="form-control" id="user_name" name="user_name" maxlength="10" placeholder="이름을 입력하세요."data-container="body" data-toggle="popover" data-placement="bottom" data-content="Vivamus
sagittis lacus vel augue laoreet rutrum faucibus.">
  </div>
  <div class="form-group">
    <label for="nickname">닉네임</label>
    <input type="hidden" id="nickname2" name="nickname2" value="" />
    <input type="text" class="form-control" id="nickname" name="nickname" maxlength="10" placeholder="닉네임을 입력하세요.">
  </div>
  <div class="form-group">
    <label for="password">비밀번호</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="비밀번호를 입력하세요.">
  </div>
  
  <button type="button" class="btn btn-primary btn-lg btn-block" onclick="form_save();">회원가입</button>
</form>
</div>

<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.footer.php"; ?>