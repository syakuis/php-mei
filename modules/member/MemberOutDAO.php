<?php
/*
 @class MemberOut

* registered date 2014-01-23
* programmed by Seok Kyun. Choi. 최석균
* http://syaku.tistory.com
*/
class MemberOutDAO {
	//out_orl, member_orl, memo, status, reg_datetime

  function insert($args) {
    $__Db = Db::getInstance();
    
		$reg_datetime = _date();
		
		$__Db->query = "INSERT INTO member_out ( member_orl, memo, status, reg_datetime ) values (
		    {$args->member_orl}
      , '{$args->memo}'
      , {$args->status}
      , '{$reg_datetime}'
		)";
    
    $__Db->insert();
	}

}
?>
