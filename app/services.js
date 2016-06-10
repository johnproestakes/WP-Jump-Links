angular.module('StarlingApp')
.factory('$Helpers', function $Helpers(){
    var self = this;
    this.stripslashes = function(str){
      return (str + '')
    .replace(/\\(.?)/g, function(s, n1) {
      switch (n1) {
        case '\\':
          return '\\';
        case '0':
          return '\u0000';
        case '':
          return '';
        default:
          return n1;
      }
    });

  };
  return this;
});
