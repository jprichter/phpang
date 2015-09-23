app.controller('AddController', ['$scope', '$location', 'BASEURL', 'Product', 
  function($scope,  $location, BASEURL, Product){
	
    $scope.product = new Product();
    $scope.addProduct = function() {
      $scope.product.$save(function(){
        $location.path('/');
      });
      
    };
      
    }
	
  ]);


