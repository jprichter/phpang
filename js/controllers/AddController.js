app.controller('AddController', ['$scope', '$firebaseArray', '$location', 'BASEURL', function($scope, $firebaseArray, $location, BASEURL){
	
	$scope.addProduct = function() {
		var ref = new Firebase(BASEURL);
		var product = $firebaseArray(ref);
		product.$add({
			sku: $scope.product.sku,
			description: $scope.product.description,
			price: $scope.product.price
		});
		$location.path('/');
	};
	
}]);


