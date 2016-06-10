angular.module('StarlingApp', ['ngRoute']);

angular.module('StarlingApp')
.config(['$routeProvider', function($routeProvider){


  
  $routeProvider.when('/main/:pageid', {
    templateUrl: baseUrl + '/app/views/main.html',
    controller: 'MainController'
  })
  .when('/redirect/:id', {
    templateUrl: baseUrl + '/app/views/redirect.html',
    controller: 'RedirectIdController'
  })
  //
  // .when('/post/new', {
  //   templateUrl: baseUrl + '/app/views/new-post.html',
  //   controller: 'NewPostController'
  // })
  //
  // .when('/posts', {
  //   templateUrl: baseUrl + '/app/views/queue.html',
  //   controller: 'PostsController'
  // })
  //
  // .when('/automation', {
  //   templateUrl: baseUrl + '/app/views/automation.html',
  //   controller: 'AutomationController'
  // })
  //
  // .when('/settings', {
  //   templateUrl: baseUrl + '/app/views/settings.html',
  //   controller: 'SettingsController'
  // })
  //
  // .when('/upload', {
  //   templateUrl: baseUrl + '/app/views/upload.html',
  //   controller: 'UploadController'
  // })

  .otherwise({redirectTo: '/main/0'});



}])

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
