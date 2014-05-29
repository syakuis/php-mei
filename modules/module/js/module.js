(function($) {

  jQuery.module = {

    module_search_url : './?module=module&act=dispModuleAdminSearchList',

    return_func : null,
    return_mid : '',
    return_module_orl : '',


    // 모듈검색 팝업 호출
    _open_search : function(return_func,sch_module) {
      this.return_func = return_func;

      if ( !jQuery.ja.isEmpty(sch_module) ) {
        this.module_search_url += '&sch_module=' + sch_module;
      }

      jQuery.ja.popup({
        url : this.module_search_url,
        width : 500,
        height : 500,
        center : true,
        scrollbars : 'yes'
      });
    },

    _open_return : function(data) {
      if ( jQuery.isFunction(this.return_func) ) {
        this.return_func(data);
      }

    },

  }
})(jQuery);
