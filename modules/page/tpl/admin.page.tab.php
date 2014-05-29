<?php if (!defined("__SYAKU__")) exit; ?>
<?php
$module_orl = _param('module_orl');
?>
<script type="text/javascript">//<![CDATA[

jQuery(function() {

  jQuery('#admin_head_tab li').bootstrap('active',{
    data : [
    { compare : ['dispPageAdminConfigList'] , index : true, rule : 'or' },
    { compare : ['dispPageAdminConfigInsert'] },
    { compare : ['dispPageAdminGrantInsert'] }
    ]
  });

});

//]]></script>

<ul class="nav nav-pills" id="admin_head_tab">
  <li><a href="./<?php echo _param_get('act=dispPageAdminConfigList&module_orl=','?')?>">목록</a></li>
  <?php if ( !empty($module_orl) ) { ?>
  <li><a href="./<?php echo _param_get('act=dispPageAdminConfigInsert','?')?>">모듈관리</a></li>
  <li><a href="./<?php echo _param_get('act=dispPageAdminGrantInsert','?')?>">권한관리</a></li>
  <?php } ?>
</ul>