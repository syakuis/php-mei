<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.header.php"; ?>

<script type="text/javascript">

jQuery.jaFilter.setDefaults({ message : filter_message });

// jaAction 필터데이터
var filter_data = [
  { target : "#user_name", params : "&filter=notnull&filter=user_name&length=2,10&title=이름" } , 
  { target : "#user_id", params : "&filter=notnull&filter=user_id&length=6,15&title=아이디" },
  { target : "#password", params : "&filter=notnull&length=6,16&title=비밀번호" },
  { target : "#password2", params : "&filter=notnull&#password=!#password2&title=비밀번호" },
  { target : "#nickname", params : "&filter=notnull&filter=nickname&length=2,10&title=닉네임" } , 
  { target : "#email", params : "&filter=notnull&filter=email&title=이메일" }
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
  data.target.after(o.stop().css("opacity", 1).fadeIn(1).delay(2000).fadeOut(1000));
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

<style>
.form_table table th, .form_table table td {
  height: 40px;
}
</style>

<h1>회원가입</h1>
<div class="sub_column_content">
<div class="content-brief">
<p>* 입력하신 아이디와 닉네임은 변경할 수 없습니다. 신중하게 입력하세요.</p>
<p>* 이메일 주소는 계정과 암호를 분실했을 때 찾을 수 있는 유일한 방법입니다. 정확하게 입력하세요.</p>
</div>

<form action="?" method="post" id="form">

  <fieldset>
		<div class="form_table">
		<table border="1" cellspacing="0">
    <colgroup>
    <col width="120"><col>
    </colgroup>
		<tbody>
		<tr>
		<th scope="row">이름</th>
		<td>
			<div class="item"><input type="text" title="이름" class="i_text w100" id="user_name" name="user_name" value="" maxlength="10" /></div>
		</td>
		</tr>
		<tr>
		<th scope="row">아이디</th>
		<td>
			<div class="item">
      <input type="hidden" id="user_id2" name="user_id2" value="" />
      <input type="text" title="아이디" class="i_text w100" id="user_id" name="user_id" value="" maxlength="15" />
		</td>
		</tr>
		<tr>
		<th scope="row">비밀번호</th>
		<td>
			<div class="item"><input type="password" title="비밀번호" class="i_text w100" id="password" name="password" value="" maxlength="16" /></div>
		</td>
		</tr>
		<tr>
		<th scope="row">비밀번호 확인</th>
		<td>
			<div class="item"><input type="password" title="비밀번호 확인" class="i_text w100" id="password2" name="password2" value="" maxlength="16" /></div>
		</td>
		</tr>
		<tr>
		<th scope="row">닉네임</th>
		<td>
			<div class="item">
      <input type="hidden" id="nickname2" name="nickname2" value="" />
      <input type="text" title="닉네임" class="i_text w100" id="nickname" name="nickname" value="" maxlength="10" />
      </div>
		</td>
		</tr>
		<tr>
		<th scope="row">이메일</th>
		<td>
			<div class="item">
      <input type="hidden" id="email2" name="email2" value="" />
      <input type="text" title="이메일" class="i_text w250" id="email" name="email" value="" />
      </div>
		</td>
		</tr>
		</tbody>
		</table>
	</div>
	</fieldset>
</form>

</div>

<div class="sub_column_footer">
<span class="button medium"><input type="button" onclick="form_save();" value="회원가입" /></span>
</div>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.footer.php"; ?>