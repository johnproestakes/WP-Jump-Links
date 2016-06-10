angular.module('StarlingApp')
.controller('RedirectIdController',
  ['$scope', '$routeParams', '$http',
  function( $scope, $routeParams, $http){

  $scope.post = {};
  $scope.siteUrl = siteUrl;


  $scope.formValidation = {
    fields: {
      title: {
        identifier: 'title',
        rules: [
          {
            type: 'empty',
            prompt: 'You must enter a title'
          }]
        },
      url   : {
        identifier:'url',
        rules:[
          {type: 'url',prompt: 'You must enter a valid URL'}
        ]
      },

    },
    on     : 'blur',
    // inline:true
  };
  $http({method:'GET', url: adminUrl + '?action=jump_links_get_id&id='+$routeParams.id}).then(function(response){
    $scope.post = response.data[0];
  }, function(){
    console.log('error');
  });


  $scope.updateRedirect = function(){
    $http({method:'POST', url: adminUrl + '?action=jump_links_update_id&id='+$routeParams.id, data:{
      url: $scope.post.url,
      title: $scope.post.title
    }}).then(
      function(response){

        location.href="#/main";
    }, function(response){
      console.log(response);
      console.log('error');
    });


  };
  $scope.removeRedirect = function(id){
    $http({method:'GET', url: adminUrl + '?action=jump_links_rm_id&id='+$routeParams.id}).then(function(response){
      location.href = "#/main";
    }, function(){
      //console.log('error');
    });

  };

}]);
