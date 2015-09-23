app.factory('Product', ['BASEURL', '$resource', function(BASEURL, $resource){
  return $resource(BASEURL, { id: '@id' }, {
    save: {method: 'POST', url: BASEURL + '/post'},
  });
}]);