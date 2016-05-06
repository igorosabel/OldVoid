(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('APIService', APIService);

  APIService.$inject = ['$http','$location','DataShareService'];
  function APIService($http,$location,DataShareService){
    var service = {};
 
    service.GetSystem         = GetSystem;
    service.GetNotifications  = GetNotifications;
    //service.people_in_system  = [];
    service.GetPeopleInSystem = GetPeopleInSystem;

    return service;
 
    function GetSystem(id, callback){
      $http.post(api_url + 'get_system', {id: id, auth: DataShareService.getUser().auth})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GetNotifications(id, callback){
      $http.post(api_url + 'get_notifications', {id: id, auth: DataShareService.getUser().auth})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GetPeopleInSystem(id, callback){
      $http.post(api_url + 'get_people_in_system', {id: id, auth: DataShareService.getUser().auth})
        .success(function (response){
          //angular.copy(response, service.people_in_system);
          callback && callback(response);
        });
    }
  }
})();