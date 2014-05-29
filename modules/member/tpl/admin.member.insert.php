<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/admin.member.header.php"; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/admin.member.tab.php";?>

<?php
  $mod = 'insert';
  if ($object != NULL) {
    $mod = 'update';
    extract($object);
    $reg_datetime = ( !empty($reg_datetime) ) ? _date('Y.m.d H:i:s',$reg_datetime) : '-'; 
    $login_datetime = ( !empty($login_datetime) ) ? _date('Y.m.d H:i:s',$login_datetime) : '-'; 
    $update_datetime = ( !empty($update_datetime) ) ? _date('Y.m.d H:i:s',$update_datetime) : '-'; 
  }
?>
<script type="text/javascript">
var mod = '<?php echo $mod?>';
jQuery.jaFilter.setDefaults({ message : filter_message });

// jaAction 필터데이터
var filter_data = [ ];

if (mod == 'insert') {

  filter_data = [
    { target : "#user_id", params : "&filter=notnull&filter=user_id&length=6,15&title=아이디" },
    { target : "#user_name", params : "&filter=notnull&filter=user_name&length=2,10&title=이름" } , 
    { target : "#nickname", params : "&filter=notnull&filter=nickname&length=2,10&title=닉네임" } , 
    { target : "#password", params : "&filter=notnull&length=6,16&title=비밀번호" },
    { target : "#email", params : "&filter=notnull&filter=email&title=이메일" }
  ];

} else {

  filter_data = [
    { target : "#nickname", params : "&filter=notnull&filter=nickname&length=2,10&title=닉네임" } , 
    { target : "#email", params : "&filter=notnull&filter=email&title=이메일" }
  ];
}

jQuery(function() {
  jQuery.ja.setValue("#form #is_admin","<?php echo $is_admin?>");
  jQuery.ja.setValue("#form #status","<?php echo $status?>");

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
  var o = jQuery("<span class='help-block'></span>").text( data.message );
  if (data.error) { data.target.focus(); }
  data.target.after(o.stop().css("opacity", 1).fadeIn(1).delay(2000).fadeOut(1000));
}

function form_save() {

  jQuery('#form').jaAction({
    filter : filter_data,
    ask : mod , 
    param : 'module=member&act=procMemberAdminInsert',
    beforeAction : function() {
      jQuery("#form #user_id2").val(jQuery("#form #user_id").val());
      jQuery("#form #nicckname2").val(jQuery("#form #nicckname").val());
      jQuery("#form #email2").val(jQuery("#form #email").val());
    },
    <?php if($mod == 'insert') { ?>
    redirect : './<?php echo _param_pick('module=&act=dispMemberAdminList','?')?>'
    <?php } else { ?>
    afterSend : function() {
      location.reload();
    }
    <?php } ?>
  });

}
</script>

<form class="form-horizontal" role="form" id="form" method="post" action="?">
<input type="hidden" name="member_orl" id="member_orl" value="<?php echo $member_orl?>" />

  <div class="form-group">
    <label for="user_id" class="col-sm-2 control-label">아이디</label>
    <div class="col-sm-10">
      <?php if ($mod == 'insert') { ?>
      <input type="hidden" id="user_id2" name="user_id2" value="<?php echo $user_id?>" />
      <input type="text" class="form-control input-sm" id="user_id" name="user_id" value="<?php echo $user_id?>" maxlength="15" />
      <?php } else { ?>
      <p class="form-control-static"><?php echo $user_id?></p>
      <?php } ?>
    </div>
  </div>

  <div class="form-group">
    <label for="user_name" class="col-sm-2 control-label">이름</label>
    <div class="col-sm-10">
      <?php if ($mod == 'insert') { ?>
      <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $user_name?>" />
      <?php } else { ?>
      <p class="form-control-static"><?php echo $user_name?></p>
      <?php } ?>
    </div>
  </div>

  <div class="form-group">
    <label for="nickname" class="col-sm-2 control-label">닉네임</label>
    <div class="col-sm-10">
      <input type="hidden" id="nickname2" name="nickname2" value="<?php echo $nickname?>" />
      <input type="text" class="form-control" id="nickname" name="nickname" value="<?php echo $nickname?>" />
    </div>
  </div>

  <div class="form-group">
    <label for="password" class="col-sm-2 control-label">비밀번호</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password" name="password" value="" />
    </div>
  </div>
  
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label">이메일</label>
    <div class="col-sm-10">
      <input type="hidden" id="email2" name="email2" value="<?php echo $email?>" />
      <input type="text" class="form-control" id="email" name="email" value="<?php echo $email?>" />
    </div>
  </div>

  <div class="form-group">
    <label for="is_admin" class="col-sm-2 control-label">최고 관리자 여부</label>
    <div class="col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" id="is_admin" name="is_admin" value="Y"> 최고 관리자 권한을 부여합니다.
        </label>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="status" class="col-sm-2 control-label">회원 상태</label>
    <div class="col-sm-10">
      <select class="form-control" name="status" id="status">
      <option value="0" selected="selected">정상</option>
      <option value="-1">정지</option>
      <option value="-2">탈퇴</option>
      </select>
    </div>
  </div>

  <?php if ($mod == 'update') { ?>
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">가입일</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $reg_datetime?></p>
    </div>
  </div>
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">최근 접속일</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $login_datetime?></p>
    </div>
  </div>
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">최근 접속 아이피</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $login_ipaddress?></p>
    </div>
  </div>
  <div class="form-group">
    <label for="" class="col-sm-2 control-label">최근 수정일</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $update_datetime?></p>
    </div>
  </div>
  <?php } ?>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10 tc">
      <a class="btn btn-default" href="./<?php echo _param_get('act=dispMemberAdminList&member_orl=','?')?>" role="button">목록</a>
      <button type="button" class="btn btn-primary" onclick="form_save();">저장</button>
    </div>
  </div>

</form>