app.controller('ListController', ['$scope', 'Product', function($scope, Product){
  
  $scope.products = Product.get();
  
  $scope.removeProduct = function(id) {
   product = Product.get({id:id});
   product.$delete({id});
  };
  
  $scope.remove = function(index){
    delete $scope.products[index];
  };
}]);

 