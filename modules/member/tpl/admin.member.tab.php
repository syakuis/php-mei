<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$module_orl = _param('module_orl');
?>
<script type="text/javascript">//<![CDATA[

jQuery(function() {

  jQuery('#admin_head_tab li').bootstrap('active',{
    data : [
    { compare : ['dispMemberAdminConfigInsert'] , index : true },
    { compare : ['dispMemberAdminList','dispMemberAdminInsert'] }
    ]
  });

});

//]]></script>

<p>
<ul class="nav nav-pills" id="admin_head_tab">
  <li><a href="./<?php echo _param_get('act=dispMemberAdminConfigInsert','?')?>">설정</a></li>
  <li><a href="./<?php echo _param_get('act=dispMemberAdminList','?')?>">회원</a></li>
</ul>
</p>