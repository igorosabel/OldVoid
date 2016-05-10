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
    service.GetPeopleInSystem = GetPeopleInSystem;
    service.Explore           = Explore;

    return service;
 
    function GetSystem(id, callback){
      $http.post(api_url + 'get_system', {id: id, auth: DataShareService.getUser().auth})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GetNotifications(callback){
      $http.post(api_url + 'get_notifications', {auth: DataShareService.getUser().auth})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GetPeopleInSystem(id, callback){
      $http.post(api_url + 'get_people_in_system', {id: id, auth: DataShareService.getUser().auth})
        .success(function (response){
          callback && callback(response);
        });
    }

    function Explore(id, type, callback){
      $http.post(api_url + 'explore', {id: id, type: type, auth: DataShareService.getUser().auth})
        .success(function (response){
          callback && callback(response);
        });
    }
  }
})();