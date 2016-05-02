(function() {
  'use strict';

  angular
    .module('VoidApp')
    .factory('APIService', APIService);

  APIService.$inject = ['$http','$location','DataShareService'];
  function APIService($http,$location,DataShareService){
    var service = {};
 
    service.GetSystem = GetSystem;

    return service;
 
    function GetSystem(id, callback) {
      $http.post(api_url + 'get_system', {id: id, auth: DataShareService.getUser().auth})
        .success(function (response) {
          callback && callback(response);
        });
    }
  }
})();