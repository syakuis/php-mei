<?php if (!defined("__SYAKU__")) exit; ?>
<style>
.tagcloud{color:#ccc;font-family:'돋움',dotum;font-size:12px;line-height:2.0;text-align:justify}
.tagcloud a{color:#7c8a8d}
.tagcloud a:hover{background-color:#1e4f55;color:#ff0}
.tagcloud a em{color:#00b4b5;font-family:'돋움',dotum;font-size:15px;font-weight:bold;letter-spacing:-1px}
.tagcloud a:hover em{background-color:#1e4f55;color:#ff0}
.tagcloud a strong{color:#3d7b66;font-family:'돋움',dotum;font-size:18px;font-weight:bold;letter-spacing:-1px}
.tagcloud a:hover strong{background-color:#1e4f55;color:#ff0}
.tagcloud a strong em{background-color:#12d763;color:#fff;font-family:'돋움',dotum;font-size:20px;font-weight:bold;letter-spacing:-1px}
.tagcloud a:hover strong em{background-color:#1e4f55;color:#ff0}

.tagcloud span { color: #FF0015 }
</style>

<div class="tagcloud">
	<?php 
    foreach ($VAR['list'] as $rs) {
      $point = $rs['document_count'] + $rs['comment_count'];
      $forum_title = $rs['forum_title'];

      if ($point > 50) {
        $forum_title = "<strong><em>{$forum_title}</em></strong>";
      } elseif ($point > 10) {
        $forum_title = "<em>{$forum_title}</em>";
      } else {
        $forum_title = "{$forum_title}";
      }
	?>
	<a href="./?mid=forum&module=document&forum_orl=<?php echo $rs['forum_orl']?>"><?php echo $forum_title?> </a>&nbsp;<span><?php echo $rs['document_count']?>/<?php echo $rs['comment_count']?></span> | 
	<?php } ?>
</div>

<div><a href="./?mid=forum&module=document&act=dispDocumentForumList">전체 보기</a></div>