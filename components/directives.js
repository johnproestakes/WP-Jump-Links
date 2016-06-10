angular.module('StarlingApp')
.directive("semanticForm", ['$timeout',function($timeout){
  return {
    restrict: 'A',
    scope: {
      formValidation: "=",
      formSubmit: "&"
    },
    link: function(scope, el, attr){
      $timeout(function(){
        jQuery(el).form(scope.formValidation);
        var debounce = null;
        jQuery(el).on('submit', function(evt){
          clearTimeout(debounce);
          debounce = setTimeout(function(){
            if(jQuery(el).form('is valid')){
              scope.formSubmit();
            } else {

            }

          },500);



          evt.preventDefault();
          return false;
        });
        scope.$on('$destroy', function(evt){
          jQuery(el).form('destroy');
          console.log('destroyed?')
        });

      });




    }
  };
}]);
