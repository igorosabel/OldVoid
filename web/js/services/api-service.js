(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('APIService', APIService);

  APIService.$inject = ['$http','$location','DataShareService'];
  function APIService($http,$location,DataShareService){
    var service = {};
 
    service.CheckExplorer     = CheckExplorer;
    service.GetSystem         = GetSystem;
    service.GetNotifications  = GetNotifications;
    service.GetPeopleInSystem = GetPeopleInSystem;
    service.Explore           = Explore;
    service.GetResources      = GetResources;
    service.GoToSystem        = GoToSystem;
    service.GetShip           = GetShip;
    service.ChangeShipName    = ChangeShipName;

    return service;

    function CheckExplorer(callback){
      $http.post(api_url + 'check_explorer', {auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GetSystem(id, callback){
      $http.post(api_url + 'get_system', {id: id, auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GetNotifications(callback){
      $http.post(api_url + 'get_notifications', {auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GetPeopleInSystem(id, callback){
      $http.post(api_url + 'get_people_in_system', {id: id, auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }

    function Explore(id, type, callback){
      $http.post(api_url + 'explore', {id: id, type: type, auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }
    
    function GetResources(id, type, callback){
      $http.post(api_url + 'get_resources', {id: id, type: type, auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GoToSystem(id, time, callback){
      $http.post(api_url + 'go_to_system', {id: id, time: time, auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }

    function GetShip(callback){
      $http.post(api_url + 'get_ship', {auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }

    function ChangeShipName(name,callback){
      $http.post(api_url + 'change_ship_name', {name: name, auth: DataShareService.GetAuth()})
        .success(function (response){
          callback && callback(response);
        });
    }
  }
})();