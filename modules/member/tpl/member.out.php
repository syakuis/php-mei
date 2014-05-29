<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.header.php"; ?>
<script type="text/javascript">

function form_out() {

  jQuery('#form').jaAction({
    filter : [
      { target : "#password", params : "&filter=notnull&title=비밀번호" }
    ],
    ask_msg : '회원탈퇴하시겠습니까?' , 
    param : 'module=member&act=procMemberOut',
    redirect : '/',
    afterSend : function() {
      alert("탈퇴 승인되었습니다.");
    }
  });
}

</script>

<style>
.form_table table th, .form_table table td {
  height: 40px;
}
</style>

<h1>회원탈퇴</h1>
<div class="sub_column_content">
<div class="content-brief">
<p>* </p>
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
		<th scope="row">비밀번호</th>
		<td>
			<div class="item">
      <input type="password" title="비밀번호" class="i_text w100" id="password" name="password" value="" maxlength="16" />
      </div>
		</td>
		</tr>
		<tr>
		<th scope="row">탈퇴 사유</th>
		<td>
			<div class="item">
      <textarea class="i_text" id="memo" name="memo" cols="80" rows="10"></textarea>
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
<span class="button medium"><input type="button" onclick="form_out();" value="회원탈퇴" /></span>
</div>

<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.footer.php"; ?>