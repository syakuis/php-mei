// 선택된 대상 효과주기 : 다중
function targetOnClass(ele,style,type,data) {
  var url = document.URL;

  var on_target;
  var def_target;

  jQuery(ele).each(function(i) {
    var cnt;
    var index;
    var def;
    var condition;

    if (data.target[i] == undefined) {
      cnt = data.target.search.length;
      search = data.target.search;
      def = data.target.def;
      condition = jQuery.ja.defString(data.target.condition,'and');
    } else {
      cnt = data.target[i].search.length;
      search = data.target[i].search;
      def = data.target[i].def;
      condition = jQuery.ja.defString(data.target[i].condition,'and');
    }

    if (def) { def_target = jQuery(this); }

    var is = true;
    var c = 0;

    for (var c = 0; c < cnt; c++ ) {
      var command;

      if (cnt == 1) { command = search; } else { command = search[c]; }
      
      if (condition == 'or') {
        if (url.indexOf(command) > -1) { is = true; break; } else { is = false; }
      } else {
        if (url.indexOf(command) == -1) { is = false; break; }
      }

    }

    if (is) { on_target = jQuery(this); }

  });

  if (on_target == null) {
    
    if (def_target != null) {

      if (jQuery.isFunction(style)) {
        style(def_target);
      } else {
        def_target.addClass(style);
      }
    }

  } else {

    if (jQuery.isFunction(style)) {
      style(on_target);
    } else {
      on_target.addClass(style);
    }


  }

}
