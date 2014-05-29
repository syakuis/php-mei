(function($) {

  jQuery.member = {

    /* action 필요 */
    user_id_regx : function(reg) {
      $.ja.regional.regx.user_id = function(val) {
        return reg.test(val);
      }
    },
    user_name_regx : function(reg) {
      $.ja.regional.regx.user_name = function(val) {
        return reg.test(val);
      }
    },
    nickname_regx : function(reg) {
      $.ja.regional.regx.nickname = function(val) {
        return reg.test(val);
      }
    },

    login : function(url, ret_url) {
      if ( js.isEmpty(ret_url) ) ret_url = (document.location.search == '') ? '' : './' + document.location.search;
      var login = ( js.isEmpty(url) ) ? "./?module=member&act=dispMemberLogin" : url;
      
      // 회원관련 링크인 경우 메인화면으로 이동
      var regx = /\=member/ig;
      if (regx.test(ret_url)) {
        ret_url = null;
      }
      if ( !js.isEmpty(ret_url) ) login = login + '&ret_url=' + encodeURIComponent(ret_url);
      location.href = login;
    },

    // 로그아웃
    logout : function(ret_url) {
      if ( js.isEmpty(ret_url) ) ret_url = _relative_path;

      jQuery.ajax({
        url : 'index.php',
        type: "post",
        data: 'module=member&act=procMemberLogout',
        success: function(xml) {
          location.href = ret_url;
        }
      });
    }, // 로그아웃

    login_confirm : function(url,ret_url) {

      if (confirm("로그인이 필요합니다. 로그인 화면으로 이동하시겠습니까?")) {
        this.login(url,ret_url);
      }

    },

    // 중복 체크
    // mode = 중복체크 형식 , func = 함수를 이용한 메세지 출력 (함수) , prepare 초기화 작업 (함수)
    repeat_check : function(mode,func,prepare) {
      var target_1 = null;
      var target_2 = null;
      var target_url = null;
      var target_filter = null;

      switch (mode) {
        case 'user_id' :
          target_1 = "#user_id";
          target_2 = "#user_id2";
          target_url = "&module=member&act=procMemberUserIdCheck";
          target_filter = "&filter=user_id&length=6,15&title=아이디";
        break;
        case 'nickname' : 
          target_1 = "#nickname";
          target_2 = "#nickname2";
          target_url = "&module=member&act=procMemberNickNameCheck";
          target_filter = "&filter=notnull&length=2,10&filter=nickname&title=닉네임";
        break;
        case 'email' : 
          target_1 = "#email";
          target_2 = "#email2";
          target_url = "&module=member&act=procMemberEmailCheck";
          target_filter = "&filter=notnull&filter=email&title=이메일";
        break;

      }

      jQuery("#form " + target_1).on("blur" , function() {
         if ($(this).val() == '') { return; }
         jQuery('#form').jaAction({
          filter : [
            { target : target_1 , params : target_filter , message : func }
          ],
          direct : target_url + '&member_orl=' + jQuery('#form #member_orl').val() + '&' + mode + '=' + jQuery("#form " + target_1).val() ,
          loading : false,

          beforeSend : function() {

            if ( jQuery.isFunction( prepare ) ) {
              prepare();
            }

            var val = jQuery('#form ' + target_1).val();
            var val2 = jQuery('#form ' + target_2).val();

            if ( (val == val2) && ( !$.ja.isEmpty(val) && !$.ja.isEmpty(val2) ) ) {
              return false;
            }
          },

          setAjax : {
            success : function(xml) {
              var data = { };
              var error = jQuery(xml).find('error').text();
              data.error = (error == 'true') ? true : false;
              data.target = jQuery('#form ' + target_1);
              data.message = jQuery(xml).find('message').text();
              func(data);

              if (data.error) {
                jQuery('#form ' + target_2).val('');
              } else {
                jQuery('#form ' + target_2).val( jQuery('#form ' + target_1).val() );
              }

            }
          }
          
        });


      });

    }

  };

})(jQuery);