<style>
#starling-app .activity-card {background: #fff; padding: 1em; margin:0;}
#starling-app .activity-card .status {display:block;}
</style>
<div class="wrap" id="starling-app" ng-app="StarlingApp">
  <div ng-controller="StarlingController">
    <nav>
      <ul>
        <li><a href="#" ng-click="">All</a></li>
        <li><a href="#" ng-click="">Published <span class="pill">1</span></a></li>
        <li><a href="#" ng-click="">Errors <span class="pill">2</span></a></li></ul>
      </nav>

    <section class="">
      <div class="activity-card" ng-repeat="_activity in activities">
        {{ _activity.content }}
        <div class="status">{{ _activity.status }}</div>
        <em>{{ _activity.postdate | date }}</em>
        {{ _activity.media }}
        </div>
    </section>
</div>
</div>
<script src="../wp-content/plugins/share-csv/js/angular.min.js"></script>
<script>
(function(){


      angular.module('StarlingApp', [])
      .controller('StarlingController', ['$scope','$http', function($scope, $http){
        $scope.hiya = "you know?";
        $scope.activities = {};
        $http({method:'GET', url:'<?=bloginfo('wpurl')?>/wp-admin/admin-ajax.php?action=share_csv_get_activity'}).then(function(response){
          console.log(response);
          $scope.activities = response.data;
        }, function(){
          console.log('error');
        });
      }]);


})();
  </script>
