angular.module('JumpLinksMetaBox', [])
.controller('MainController',['$scope', '$http', function($scope, $http){
  $scope.title = "holler";
  $scope.form = {
    url: "",
    title: ""
  };
  $scope.generated = [];

  $scope.insertUrl = function(){
    $http({
      url: ajaxurl + "?action=jump_links_insert_url",
      data: $scope.form,
      method: "POST"
    }).then(function(response){
      console.log(response);
      if(response.data && response.data.url) {
        $scope.generated.push(response.data.url);
      }

    }, function(){
      console.error('Error');
    });
  };
}]);
