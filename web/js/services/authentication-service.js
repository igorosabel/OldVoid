(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('AuthenticationService', AuthenticationService);
 
  AuthenticationService.$inject = ['$http','$location','DataShareService'];
  function AuthenticationService($http,$location,DataShareService){
    var service = {};
 
    service.Login             = Login;
    service.Logout            = Logout;
    service.RegisterExplorer  = RegisterExplorer;
    service.SetCredentials    = SetCredentials;
    service.ClearCredentials  = ClearCredentials;
    service.SaveLocalstorage  = SaveLocalstorage;
    service.loadLocalStorage  = LoadLocalStorage;
 
    return service;
 
    function Login(email, pass, callback){
      $http.post(api_url+'login', { email: email, pass: pass })
        .success(function (response) {
          callback && callback(response);
        });
    }
    
    function Logout(){
      ClearCredentials();
  
      $location.path('/');
    }
    
    function RegisterExplorer(name, email, pass, callback){
      $http.post(api_url+'register', { name: name, email: email, pass: pass })
        .success(function (response) {
          callback && callback(response);
        });
    }
 
    function SetCredentials(data){
      DataShareService.SetUser({
        id: data.id_user,
        name: urldecode(data.name),
        email: urldecode(data.email),
        credits: data.credits,
        auth: data.auth
      });
      DataShareService.SetShip({
        current: data.ship.current,
        strength: data.ship.strength,
        fuel: data.ship.fuel
      });
      DataShareService.SetSystem(data.system);
    }
    
    function ClearCredentials(){
      DataShareService.ResetUser();
      DataShareService.ResetShip();
      DataShareService.ResetSystem();
      localStorage.removeItem('void_user_data');
      localStorage.removeItem('void_ship_data');
      localStorage.removeItem('void_system_data');
    }
    
    function SaveLocalstorage(){
      localStorage.setItem('void_user_data',  JSON.stringify(DataShareService.GetUser()));
      localStorage.setItem('void_ship_data',  JSON.stringify(DataShareService.GetShip()));
      localStorage.setItem('void_system_data',JSON.stringify(DataShareService.GetSystem()));
    }
    
    function LoadLocalStorage(){
      var void_user_data   = localStorage.getItem('void_user_data');
      var void_ship_data   = localStorage.getItem('void_ship_data');
      var void_system_data = localStorage.getItem('void_system_data');
      if (void_user_data && void_ship_data && void_system_data){
        DataShareService.SetUser(  JSON.parse(void_user_data));
        DataShareService.SetShip(  JSON.parse(void_ship_data));
        DataShareService.SetSystem(JSON.parse(void_system_data));
        return true;
      }
      return false;
    }
  }
})();