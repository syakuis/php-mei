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

<div class="sub_column_content">

  <form action="?" method="post" id="form_userid">
  <fieldset>
		<div class="form_table">
    <div class="mtitle">아이디 찾기</div>
		<table border="1" cellspacing="0">
    <colgroup>
    <col width="120"><col>
    </colgroup>
		<tbody>
		<tr>
		<th scope="row">이름</th>
		<td>
			<div class="item">
      <input type="text" title="이름" class="i_text w100" id="user_name" name="user_name" value="" maxlength="10" />
      </div>
		</td>
		</tr>
		<tr>
		<th scope="row">이메일</th>
		<td>
			<div class="item">
      <input type="text" title="이메일" class="i_text w250" id="email" name="email" value="" />
      </div>
		</td>
		</tr>
		<tr>
		<th scope="row">결과</th>
		<td>
			<div class="item">
      <p class='i_dsc' id="userid_search"></p>
      </div>
		</td>
		</tr>
		</tbody>
		</table>
	</div>
	</fieldset>
  <div>
    <span class="button medium"><input type="button" onclick="user_id_search();" value="아이디 찾기" /></span>
  </div>
  </form>

  <form action="?" method="post" id="form_password">
  <fieldset>
		<div class="form_table">
    <div class="mtitle">비밀번호 찾기</div>
		<table border="1" cellspacing="0">
    <colgroup>
    <col width="120"><col>
    </colgroup>
		<tbody>
		<tr>
		<th scope="row">이름</th>
		<td>
			<div class="item">
      <input type="text" title="이름" class="i_text w100" id="user_name" name="user_name" value="" maxlength="10" />
      </div>
		</td>
		</tr>
		<tr>
		<th scope="row">아이디</th>
		<td>
			<div class="item">
      <input type="text" title="아이디" class="i_text w100" id="user_id" name="user_id" value="" maxlength="15" />
		</td>
		</tr>
		<tr>
		<th scope="row">이메일</th>
		<td>
			<div class="item">
      <input type="text" title="이메일" class="i_text w250" id="email" name="email" value="" />
      </div>
		</td>
		</tr>
		<tr>
		<th scope="row">결과</th>
		<td>
			<div class="item">
      <p class='i_dsc' id="password_search"></p>
      </div>
		</td>
		</tr>
		</tbody>
		</table>
	</div>
	</fieldset>
  <div>
    <span class="button medium"><input type="button" onclick="password_search();" value="비밀번호 찾기" /></span>
  </div>
  </form>

</div>

<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/member.footer.php"; ?>