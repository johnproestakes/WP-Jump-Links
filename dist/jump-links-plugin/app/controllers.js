angular.module('StarlingApp')
.controller('MainController', ['$scope', '$http','$routeParams', function($scope, $http, $routeParams){
  $scope.results = [];
  $scope.siteUrl = siteUrl;


$scope.sortby = "timestamp";
$scope.sort = false;
$scope.currentPage = 0;
$scope.setSort = function(id){
  if($scope.sortby == id){
    $scope.sort = !$scope.sort;
  } else {
    $scope.sortby = id;
    $scope.sort = true;
  }
  $scope.refresh($scope.currentPage);
  //update query;
}
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

$scope.pages = [];
$scope.formFields = {
  url: "",
  title: ""

};
$scope.editItem = function(id){
  location.href="#/redirect/"+id;
};
$scope.isCurrentPage = function(key){
  console.log(key, $routeParams.pageid);
  if(!$routeParams.pageid || key == $routeParams.pageid){
    return true;
  } else {
    return false;
  }
}
$scope.refresh = function(pageid){
  $scope.currentPage = pageid;
  $http({method:"GET", url: adminUrl + "?action=jump_links_get_list&pageid="+ pageid + "&sortby="+$scope.sortby+"&sort="+($scope.sort ? "ASC" : "DESC"), data:{}}).then(function(response){
    if(response.data){
        $scope.results = response.data.results;
        console.log(response.data.pages, response.data.count);
        $scope.pages = new Array(response.data.pages);
    }
    console.log(adminUrl + "?action=jump_links_get_list");
    console.log(response);
  },function(){});

};

$scope.refresh($routeParams.pageid);
$scope.insertUrl = function(){
  $http({method:"POST", url: adminUrl + "?action=jump_links_insert_url", data:{
    url: $scope.formFields.url,
    title: $scope.formFields.title
  }}).then(function(response){
    if(response.data && response.data[0] && response.data[0].errors){
      console.log();
        //$scope.results = response.data;
        alert(response.data[0].errors);
    }
    else {
      console.log(response);
      $scope.formFields = {
        url: "",
        title: ""

      };
      $scope.refresh($scope.currentPage);
    }
    console.log(adminUrl + "?action=jump_links_get_list");
    console.log(response);
  },function(){});
};


}]);

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