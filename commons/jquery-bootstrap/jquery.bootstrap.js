/**
* jQuery Bootstrap
* @brief Bootstrap

 * Copyright (c) Seok Kyun. Choi. 최석균
 * GNU Lesser General Public License
 * http://www.gnu.org/licenses/lgpl.html
 *
 * registered date 20080327
 * http://syaku.tistory.com
*/
(function($) {

  function log(text) {
    try {
      console.log(text);
    } catch (e) { }
  }

  // 링크 효과주기
  $.bsActive = {
    element : null,
    data : null,
    clss : 'active',
    link : document.URL,

    reset : function() {
      var items = this.data;
      var v = { compare : [ ] , index : false, rule : 'or' }; // 기본값

      items.each(function(i) {
        $.extend(true,items[i],v);
      });

      this.data = items;
    },

    compare : function(value,rule) {
      var cnt = value.length;
      var is = false;
      for (var i = 0; i < cnt; i++ ) {
        is = (this.link.indexOf(value[i]) > -1) ? true : false;
        if (rule == 'or' && is) { is = true; break; }
        if (rule == 'and' && !is) { is = false; break; }
      }
      return is;
    },

    active : function() {
      var jq = this;
      var obj = this.element;
      var items = this.data;

      var obj_cnt = obj.length;
      var opt_cnt = items.length;

      var def_idx = null;
      var act_idx = null;

      for (var i = 0; i < obj_cnt; i++ ) {
        
        if (items[i].index && def_idx == null) def_idx = i;
        var is = this.compare(items[i].compare,items[i].rule);
        if (is) act_idx = i;
      }

      if (act_idx == null && def_idx != null) act_idx = def_obj;

      if (act_idx !=null) {
        obj.eq(act_idx).addClass(this.clss);
      }
    },

    init : function(element,options) {
      this.element = $(element);
      this.data = $(options.data);
      this.reset();
      this.active();
    }

  }

  $.fn.bootstrap = function(method,options) {

    switch(method) {
      case 'active' :
        $.bsActive.init(this,options);
      break;
    }

  };

})(jQuery);
