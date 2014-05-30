<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/admin.member.header.php"; ?>
<?php include_once "{$GV['_MEMBER_']['MODULE_PATH']}/tpl/admin.member.tab.php";?>

<script type="text/javascript">

  // 회원 삭제
  function member_delete(member_orl) {
    jQuery('#form').jaAction({
      formAttr : 'method=post',
      param : '<?php echo _param_pick("module=&act=procMemberAdminDelete")?>&member_orl=' + member_orl , 
      ask : 'del' ,
      afterSend : function() { location.reload(); }
    });
  }
</script>

<form id="form" method="get" action="?">
<table class="table table-hover">
<colgroup>
<col width="100"><col width="160"><col width="80"><col><col width="120"><col width="120">
</colgroup>
<thead>
<tr>
<th scope="col">기능</th>
<th scope="col">아이디</th>
<th scope="col">이름</th>
<th scope="col">이메일</th>
<th scope="col">접속일</th>
<th scope="col">가입일</th>
</tr>
</thead>
<tbody>

<?php
foreach($list as $rs) {
  $member_orl = $rs['member_orl'];
  $user_id = $rs['user_id'];
  $user_name = $rs['user_name'];
  $nickname = $rs['nickname'];
  $password = $rs['password'];
  $email = $rs['email'];
  $email_id = $rs['email_id'];
  $email_host = $rs['email_host'];
  $memo = $rs['memo'];
	$reg_datetime = ( !empty($rs['reg_datetime']) ) ? _date('Y.m.d H:i:s',$rs['reg_datetime']) : '-'; 
	$login_datetime = ( !empty($rs['login_datetime']) ) ? _date('Y.m.d H:i:s',$rs['login_datetime']) : '-'; 
?>
<tr>
<td>
<a class="btn btn-default btn-xs" href="./<?php echo _param_pick("mid=&module=&act=dispMemberAdminInsert&member_orl={$member_orl}",'?')?>" role="button"><span class="glyphicon glyphicon-cog"></span></a>
<button type="button" class="btn btn-default btn-xs" onclick="member_delete('<?php echo $member_orl?>');"><span class="glyphicon glyphicon-trash"></span></button>
</td>
<td><?php echo $nickname?> (<?php echo $user_id?>)</td>
<td><?php echo $user_name?></td>
<td><?php echo $email?></td>
<td class="num"><?php echo $login_datetime ?></td>
<td class="num"><?php echo $reg_datetime ?></td>
</tr>
<?php } ?>
<?php if ($pages['total_count'] == 0) { ?>
<tr>
	<td colspan="6">등록된 게시물이 없습니다.</td>
</tr>
<?php }?>
</tbody>
</table>
</form>

<div class="row">
  <div class="col-md-8">

  <ul class="pagination pagination-sm" id="document_navi">
    <li class="prev"><a href="#">&laquo;</a></li>
    <li class="disabled prevx"><a href="#">&laquo;</a></li>
    <span class="pageaction"></span>
    <li class="num"><a href="#">{page}</a></li>
    <li class="active now"><a href="#">{page} <span class="sr-only">(current)</span></a></li>
    <li class="next"><a href="#">&raquo;</a></li>
    <li class="disabled nextx"><a href="#">&raquo;</a></li>
  </ul>

  <script type="text/javascript">
    jQuery('#document_navi').jaPageNavigator({
      page_row : "<?php echo $pages['page_row']?>"
    , page_link : "<?php echo $pages['page_link']?>"
    , page : "<?php echo $pages['page']?>"
    , total_count : "<?php echo $pages['total_count']?>"
    });
  </script>

  </div>

  <div class="col-md-4 tr">
    <a class="btn btn-default btn-sm mt20" href="./<?php echo _param_pick('mid=&module=&act=dispMemberAdminInsert','?')?>" role="button">등록</a>
  </div>

</div>