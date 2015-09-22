app.factory('Product', ['BASEURL', '$resource', function(BASEURL, $resource){
  return $resource(BASEURL, { id: '@id' }, {
    update: {
      method: 'PUT'
    }
  });
}]);