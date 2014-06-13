<?php if (!defined("__SYAKU__")) exit; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/admin.document.header.php"; ?>
<?php include_once "{$GV['_DOCUMENT_']['MODULE_PATH']}/tpl/admin.document.tab.php";?>
<?php
$module_orl = _param('module_orl');
$mod = 'insert';

if ($object != NULL) {
  $rs = $object;
  $mod = 'update';

  $module_id = htmlspecialchars($rs['mid']);
  $module_title = htmlspecialchars($rs['module_title']);
  $browser_title = htmlspecialchars($rs['browser_title']);
  
  $layout_orl = $rs['layout_orl'];
  $skin = $rs['skin'];
  $header_content = $rs['header_content'];
  $footer_content = $rs['footer_content'];

  $options_is_comment = htmlspecialchars($rs['options_is_comment']);
  $options_comment_skin = htmlspecialchars($rs['options_comment_skin']);
  $options_is_comment_page = htmlspecialchars($rs['options_is_comment_page']);
  $options_comment_page_count = htmlspecialchars($rs['options_comment_page_count']);
  $options_comment_list_count = htmlspecialchars($rs['options_comment_list_count']);

  $options_view_listoutput = htmlspecialchars($rs['options_view_listoutput']);
  $options_list_type = htmlspecialchars($rs['options_list_type']);
  $options_order_target = htmlspecialchars($rs['options_order_target']);
  $options_order_type = htmlspecialchars($rs['options_order_type']);
  $options_list_count = htmlspecialchars($rs['options_list_count']);
  $options_page_count = htmlspecialchars($rs['options_page_count']);
  $options_icons = htmlspecialchars($rs['options_icons']);

  $options_editor = htmlspecialchars($rs['options_editor']);
  $options_is_notice = htmlspecialchars($rs['options_is_notice']);
  $options_is_subject_style = htmlspecialchars($rs['options_is_subject_style']);
  $options_input_height = htmlspecialchars($rs['options_input_height']);

  $options_is_file = htmlspecialchars($rs['options_is_file']);
  $options_file_type = htmlspecialchars($rs['options_file_type']);
  $options_file_once_size = htmlspecialchars($rs['options_file_once_size']);
  $options_file_size = htmlspecialchars($rs['options_file_size']);
  $options_file_limit = htmlspecialchars($rs['options_file_limit']);
}
?>

<script type="text/javascript">//<![CDATA[

var mod = '<?php echo $mod;?>';
jQuery(function() {

if (mod == "update") {
  jQuery.ja.setValue("#form #layout_orl","<?php echo $layout_orl?>");
  jQuery.ja.setValue("#form #skin","<?php echo $skin?>");

  jQuery.ja.setValue("#form #options_is_comment","<?php echo $options_is_comment?>");
  jQuery.ja.setValue("#form #options_comment_skin","<?php echo $options_comment_skin?>");
  
  jQuery.ja.setValue("#form #options_is_comment_page","<?php echo $options_is_comment_page?>");
  
  jQuery.ja.setValue("#form #options_view_listoutput","<?php echo $options_view_listoutput?>");
  jQuery.ja.setValue("#form #options_list_type","<?php echo $options_list_type?>");

  jQuery.ja.setValue("#form #options_order_target","<?php echo $options_order_target?>");
  jQuery.ja.setValue("#form #options_order_type","<?php echo $options_order_type?>");

  var options_icons = "<?php echo $options_icons?>";
  jQuery('#form .options_icons').each(function() {
    var val = jQuery(this).val();
    if (options_icons.indexOf(val) > -1 ){
      jQuery(this).prop("checked",true);
    }
  });
  
  jQuery.ja.setValue("#form #options_editor","<?php echo $options_editor?>");
  jQuery.ja.setValue("#form #options_is_notice","<?php echo $options_is_notice?>");
  jQuery.ja.setValue("#form #options_is_subject_style","<?php echo $options_is_subject_style?>");

  jQuery.ja.setValue("#form #options_is_file","<?php echo $options_is_file?>");
}

});

function save() {

  jQuery('#form').jaAction({
    filter : [
      { target : "#module_id", params : "&filter=user_id&filter=notnull&title=MID" },
      { target : "#module_title", params : "&filter=notnull&filter=notnull&title=모듈명" },
      { target : "#browser_title", params : "&filter=notnull&title=브라우저 제목" },
      { target : "#skin", params : "&filter=notnull&title=스킨" },
      { target : "#options_list_count", params : "&filter=number&title=목록수" },
      { target : "#options_page_count", params : "&filter=number&title=페이지수" }
    ],
    param : '<?php echo _param_pick("module=&act=procDocumentAdminConfigInsert")?>' , 
    ask : mod,
    afterSend : (mod == 'insert') ? function() { location.href='./<?php echo _param_pick('module=&act=dispDocumentAdminConfigList','?')?>'; } : function() { location.reload(); }
  });

}

//]]></script>

<ul class="nav nav-pills">
  <li class="active"><a href="#module-config" data-toggle="tab">모듈설정</a></li>
  <li><a href="#output-config" data-toggle="tab">출력설정</a></li>
  <li><a href="#input-config" data-toggle="tab">입력설정</a></li>
  <li><a href="#file-config" data-toggle="tab">첨부설정</a></li>
  <li><a href="#comment-config" data-toggle="tab">댓글설정</a></li>
  <li><a href="#other-config" data-toggle="tab">기타설정</a></li>
</ul>

<form class="form-horizontal" role="form" id="form" method="post" action="?">
<input type="hidden" name="module_orl" id="module_orl" value="<?php echo $module_orl?>" />

<div class="tab-content">

  <!-- 모듈설정 -->
  <div class="tab-pane active" id="module-config">
  <p>&nbsp;</p>
  <div class="form-group">
    <label for="module_id" class="col-sm-2 control-label">MID</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="module_id" name="module_id" value="<?php echo $module_id?>" />
      <span class="help-block">알파벳 소문자와 숫자 _ 를 사용하여 MID를 완성하세요.</span>
    </div>
  </div>

  <div class="form-group">
    <label for="module_title" class="col-sm-2 control-label">모듈명</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="module_title" name="module_title" value="<?php echo $module_title?>" placeholder="모듈명을 입력하세요." />
      <span class="help-block">쉽게 알아 볼 수 있는 모듈명을 완성하세요.</span>
    </div>
  </div>

  <div class="form-group">
    <label for="browser_title" class="col-sm-2 control-label">브라우저 제목</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="browser_title" name="browser_title" value="<?php echo $browser_title?>" placeholder="브라우저 제목을 입력하세요." />
    </div>
  </div>

  <div class="form-group">
    <label for="layout_orl" class="col-sm-2 control-label">레이아웃</label>
    <div class="col-sm-10">

      <select class="form-control" name="layout_orl" id="layout_orl">
      <option value="0" selected="selected">선택</option>
      <?php foreach($layout_list as $layout) { ?>
      <option value="<?php echo $layout['layout_orl']?>"><?php echo $layout['title']?></option>
      <?php } ?>
      </select>

    </div>
  </div>

  <div class="form-group">
    <label for="skin" class="col-sm-2 control-label">스킨</label>
    <div class="col-sm-10">

      <select class="form-control" name="skin" id="skin">
      <option value="0" selected="selected">선택</option>
      <?php foreach($skin_list as $skin) { ?>
      <option value="<?php echo $skin?>"><?php echo $skin?></option>
      <?php } ?>
      </select>
      <span class="help-block">스킨을 변경할 경우 꼭 저장부터 하세요.</span>
    </div>
  </div>

  </div>

  <!-- 출력설정 -->
  <div class="tab-pane" id="output-config">
  <p>&nbsp;</p>
  <div class="form-group">
    <label for="options_view_listoutput" class="col-sm-2 control-label">목록 노출여부</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_view_listoutput" id="options_view_listoutput">
      <option value="N" selected="selected">사용안함</option>
      <option value="Y">사용</option>
      </select>
      <span class="help-block">상세보기 맨 하단에 목록이 노출됩니다.</span>
    </div>
  </div>

  <div class="form-group">
    <label for="options_list_type" class="col-sm-2 control-label">목록 형식</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_list_type" id="options_list_type">
      <option value="list" selected="selected">일반</option>
      <option value="gallery">갤러리</option>
      <option value="blog">블로그</option>
      <option value="media">미디어</option>
      </select>
      <span class="help-block">목록을 어떤 형식을 노출하는 지 선택하세요.</span>
    </div>
  </div>

  <div class="form-group">
    <label for="options_order_target" class="col-sm-2 control-label">정렬순서</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_order_target" id="options_order_target">
      <option selected="selected" value="">등록순</option>
      <option value="document_orl">번호</option>
      <option value="reg_datetime">등록일</option>
      <option value="readed_count">조회 수</option>
      <option value="title">제목</option>
      </select>
      <span class="help-block">기본으로 선택할 경우 등록순으로 정렬됩니다.</span>
    </div>
  </div>
  <div class="form-group">
    <label for="options_order_type" class="col-sm-2 control-label">정렬방식</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_order_type" id="options_order_type">
        <option selected="selected" value="desc">내림차순</option>
        <option value="asc">오름차순</option>
      </select>
      <span class="help-block">목록의 기본 정렬 항목과 정렬 방식을 지정합니다.</span>
    </div>
  </div>
  <div class="form-group">
    <label for="options_list_count" class="col-sm-2 control-label">목록수</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_list_count" name="options_list_count" value="<?php echo $options_list_count?>" placeholder="모듈명을 입력하세요." />
      <span class="help-block">한 페이지에 표시될 글 수를 지정하실 수 있습니다. (기본 20개)</span>
    </div>
  </div>
  <div class="form-group">
    <label for="options_page_count" class="col-sm-2 control-label">페이지수</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_page_count" name="options_page_count" value="<?php echo $options_page_count?>" placeholder="모듈명을 입력하세요." />
      <span class="help-block">목록 하단, 페이지를 이동하는 링크 수를 지정하실 수 있습니다. (기본 10개)</span>
    </div>
  </div>
  <div class="form-group">
    <label for="options_icons1" class="col-sm-2 control-label">아이콘표시</label>
    <div class="col-sm-10">
      <label class="checkbox-inline">
        <input type="checkbox" id="options_icons1" class="options_icons" name="options_icons[]" value="new"> 새글
      </label>
      <label class="checkbox-inline">
        <input type="checkbox" id="options_icons2" class="options_icons" name="options_icons[]" value="update"> 업데이트
      </label>
      <label class="checkbox-inline">
        <input type="checkbox" id="options_icons3" class="options_icons" name="options_icons[]" value="file"> 파일
      </label>
      <span class="help-block">목록의 제목 옆에 출력되는 아이콘들을 지정할 수 있습니다.</span>
    </div>
  </div>
  </div>

  <!-- 입력설정 -->
  <div class="tab-pane" id="input-config">
  <p>&nbsp;</p>
  <div class="form-group">
    <label for="options_editor" class="col-sm-2 control-label">위지윅에디터</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_editor" id="options_editor">
      <option value="" selected="selected">사용안함</option>
      <?php foreach($editor_list as $name) { ?>
      <option value="<?php echo $name?>"><?php echo $name?></option>
      <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="options_is_notice" class="col-sm-2 control-label">공지 사용여부</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_is_notice" id="options_is_notice">
      <option value="N" selected="selected">사용안함</option>
      <option value="Y">사용</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="options_is_subject_style" class="col-sm-2 control-label">제목 효과 사용여부</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_is_subject_style" id="options_is_subject_style">
      <option value="N" selected="selected">사용안함</option>
      <option value="Y">사용</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="options_input_height" class="col-sm-2 control-label">내용 입력 높이</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_input_height" name="options_input_height" value="<?php echo $options_input_height?>" />
    </div>
  </div>
  </div>

  <!-- 첨부설정 -->
  <div class="tab-pane" id="file-config">
  <p>&nbsp;</p>
  <div class="form-group">
    <label for="options_is_file" class="col-sm-2 control-label">사용여부</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_is_file" id="options_is_file">
      <option value="N" selected="selected">사용안함</option>
      <option value="Y">사용</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="options_file_type" class="col-sm-2 control-label">허용 확장자</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_file_type" name="options_file_type" value="<?php echo $options_file_type?>" />
      <span class="help-block">허용한 확장자만 첨부할 수 있습니다. "*.확장자"로 지정할 수 있고 ";" 으로 여러 개 지정이 가능합니다.<br />예) *.* or *.jpg;*.gif;</span>
    </div>
  </div>
  <div class="form-group">
    <label for="options_file_once_size" class="col-sm-2 control-label">개당 제한 용량</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_file_once_size" name="options_file_once_size" value="<?php echo $options_file_once_size?>" />
      <span class="help-block">하나의 파일에 대해 최고 용량을 지정할 수 있습니다. 정수로만 입력하세요. (KB 단위)</span>
    </div>
  </div>
  <div class="form-group">
    <label for="options_file_size" class="col-sm-2 control-label">전체 제한 용량</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_file_size" name="options_file_size" value="<?php echo $options_file_size?>" />
      <span class="help-block">하나의 문서에 첨부할 수 있는 최고 용량을 지정할 수 있습니다. 정수로만 입력하세요. (KB 단위)</span>
    </div>
  </div>
  <div class="form-group">
    <label for="options_file_limit" class="col-sm-2 control-label">제한 수</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_file_limit" name="options_file_limit" value="<?php echo $options_file_limit?>" />
      <span class="help-block">파일을 첨부할 수 있는 최대 수를 지정할 수 있습니다. 0을 지정하면 제한하지 않습니다. 정수로만 입력하세요.</span>
    </div>
  </div>
  </div>

  <!-- 댓글설정 -->
  <div class="tab-pane" id="comment-config">
  <p>&nbsp;</p>
  <div class="form-group">
    <label for="options_is_comment" class="col-sm-2 control-label">댓글 사용여부</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_is_comment" id="options_is_comment">
      <option value="N" selected="selected">사용안함</option>
      <option value="Y">사용</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="options_comment_skin" class="col-sm-2 control-label">댓글 스킨</label>
    <div class="col-sm-10">

      <select class="form-control" name="options_comment_skin" id="options_comment_skin">
      <option value="0" selected="selected">선택</option>
      <?php foreach($comment_skin_list as $skin) { ?>
      <option value="<?php echo $skin?>"><?php echo $skin?></option>
      <?php } ?>
      </select>

    </div>
  </div>

  <div class="form-group">
    <label for="options_is_comment_page" class="col-sm-2 control-label">페이지 사용여부</label>
    <div class="col-sm-10">
      <select class="form-control" name="options_is_comment_page" id="options_is_comment_page">
      <option value="N" selected="selected">사용안함</option>
      <option value="Y">사용</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label for="options_comment_list_count" class="col-sm-2 control-label">목록수</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_comment_list_count" name="options_comment_list_count" value="<?php echo $options_comment_list_count?>" />
      <span class="help-block">한 페이지에 표시될 글 수를 지정하실 수 있습니다. (기본 20개)</span>
    </div>
  </div>

  <div class="form-group">
    <label for="options_comment_page_count" class="col-sm-2 control-label">페이지수</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="options_comment_page_count" name="options_comment_page_count" value="<?php echo $options_comment_page_count?>" />
      <span class="help-block">목록 하단, 페이지를 이동하는 링크 수를 지정하실 수 있습니다. (기본 10개)</span>
    </div>
  </div>
  </div>

  <!-- 기타설정 -->
  <div class="tab-pane" id="other-config">
  <p>&nbsp;</p>
  <div class="form-group">
    <label for="header_content" class="col-sm-2 control-label">상단 내용</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="header_content" name="header_content" cols="80" rows="5"><?php echo $header_content?></textarea>
      <span class="help-block">해당 게시판 모듈의 상, 하단에 출력될 내용을 지정할 수 있습니다.</span>
    </div>
  </div>

  <div class="form-group">
    <label for="footer_content" class="col-sm-2 control-label">하단 내용</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="footer_content" name="footer_content" cols="80" rows="5"><?php echo $footer_content?></textarea>
      <span class="help-block">해당 게시판 모듈의 상, 하단에 출력될 내용을 지정할 수 있습니다.</span>
    </div>
  </div>
  </div>

</div>

<div class="text-center">
<a class="btn btn-default" href="./<?php echo _param_get('act=dispDocumentAdminConfigList&module_orl=','?')?>" role="button">목록</a>
<button type="button" class="btn btn-info" onclick="save();">저장</button>
</div>

</form>