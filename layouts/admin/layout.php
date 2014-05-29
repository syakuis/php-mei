<?php if (!defined("__SYAKU__")) exit; ?>
<script type="text/javascript">//<![CDATA[

jQuery(function() {

  jQuery('#admin_sidebar_menu a').bootstrap('active',{
    data : [
    { compare : ['module=message'] },
    { compare : ['module=layout'] },
    { compare : ['module=page'] },
    { compare : ['module=member'] },
    { compare : ['module=document'] }
    ]
  });

});

//]]></script>

<div id="wrap">

<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./?module=admin">PHP-MEI</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="./">Home</a></li>
        <li><a href="./?module=admin">Settings</a></li>
        <?php if ($GRANT['GRANT_LOGIN']) { ?>
        <li><a href="javascript:jQuery.member.logout();">Sing Out</a></li>
        <?php } ?>
      </ul>
    </div>
  </div><!-- /.container -->
</div><!-- /.navbar -->

<div class="container">

  <div class="row row-offcanvas row-offcanvas-right">

    <div class="col-xs-12 col-sm-9">
      <?php echo $MODULE_CONTENT?>
    </div><!--/span-->

    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
      <div class="list-group" id="admin_sidebar_menu">
        <a href="./?module=admin&act=dispMessageAdminConfigInsert" class="list-group-item">메세지</a>
        <a href="./?module=admin&act=dispLayoutAdminList" class="list-group-item">레이아웃</a>
        <a href="./?module=admin&act=dispPageAdminConfigList" class="list-group-item">페이지</a>
        <a href="./?module=admin&act=dispMemberAdminConfigInsert" class="list-group-item">회원</a>
        <a href="./?module=admin&act=dispDocumentAdminConfigList" class="list-group-item">게시판</a>
      </div>
    </div><!--/span-->
  </div><!--/row-->

  <hr>

  <footer>
    <p>&copy; Company 2014</p>
  </footer>

</div><!--/.container-->

</div>