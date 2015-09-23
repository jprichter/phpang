app.controller('EditController', ['$scope','$location', '$routeParams', 'Product', 'BASEURL',   
    function($scope, $location, $routeParams, Product, BASEURL){
    
    Product.get({id: $routeParams.id},
      function (data) { // success!
        $scope.product = data;
      },
      function (data){ //fail!
        console.log(data);
      });
          
    $scope.editProduct = function() {
        $scope.product.$update(function (){
          $scope.edit_form.$setPristine();
          $scope.product = {};
          $location.path('/products');
          
        });
        
    };
     
}]);