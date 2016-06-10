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
