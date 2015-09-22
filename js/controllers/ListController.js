app.controller('ListController', ['$scope', 'Product', function($scope, Product){
  
  Product.get(
  {},
  function (data) { // success!
    $scope.products = data;
  },
  function (data){ //fail!
    console.log(data);
  })
  
  
  
  
  /* $scope.removeProduct = function(id) {
    var ref = new Firebase(BASEURL + id);
    var product = $firebaseObject(ref)
    product.$remove();
   }; */
   
}]);

 