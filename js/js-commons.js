
var js = {
  log : function(text) {
    try { console.log(text); }
    catch (e) { }
  },
  isEmpty : function(str) {
    if (this.isNull(str)) return true;
    if (typeof str == 'string') {
      str.replace(/\s+/g,'');
      return (str == '');
    } else {
      this.log('not string');
    }
  },
  isNull : function(str) {
    return (str === undefined || str === null);
  }
};