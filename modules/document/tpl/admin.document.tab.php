<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$module_orl = _param('module_orl');
?>
<script type="text/javascript">//<![CDATA[

jQuery(function() {

  jQuery('#admin_head_tab li').bootstrap('active',{
    data : [
    { compare : ['dispDocumentAdminConfigList'] , index : true },
    { compare : ['dispDocumentAdminConfigInsert'] },
    { compare : ['dispDocumentAdminGrantInsert'] }
    ]
  });

});

//]]></script>
<ul class="nav nav-tabs" id="admin_head_tab">
  <li><a href="./<?php echo _param_get('act=dispDocumentAdminConfigList&module_orl=','?')?>">목록</a></li>
  <?php if ( !empty($module_orl) ) { ?>
  <li><a href="./<?php echo _param_get('act=dispDocumentAdminConfigInsert','?')?>">모듈관리</a></li>
  <li><a href="./<?php echo _param_get('act=dispDocumentAdminGrantInsert','?')?>">권한관리</a></li>
  <?php } ?>
</ul>
<p></p>