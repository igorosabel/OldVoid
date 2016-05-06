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
      DataShareService.setUser({
        id: data.id_user,
        name: urldecode(data.name),
        email: urldecode(data.email),
        credits: data.credits,
        auth: data.auth
      });
      DataShareService.setShip({
        current: data.ship.current,
        strength: data.ship.strength,
        fuel: data.ship.fuel
      });
      DataShareService.setSystem({
        current: data.system.current,
        name: urldecode(data.system.name),
        type: urldecode(data.system.type),
        planets: data.system.planets,
        explorers: data.system.explorers,
        npc: data.system.npc
      });
    }
    
    function ClearCredentials(){
      DataShareService.resetUser();
      DataShareService.resetShip();
      DataShareService.resetSystem();
      localStorage.removeItem('void_user_data');
      localStorage.removeItem('void_ship_data');
      localStorage.removeItem('void_system_data');
    }
    
    function SaveLocalstorage(){
      localStorage.setItem('void_user_data',  JSON.stringify(DataShareService.getUser()));
      localStorage.setItem('void_ship_data',  JSON.stringify(DataShareService.getShip()));
      localStorage.setItem('void_system_data',JSON.stringify(DataShareService.getSystem()));
    }
    
    function LoadLocalStorage(){
      var void_user_data   = localStorage.getItem('void_user_data');
      var void_ship_data   = localStorage.getItem('void_ship_data');
      var void_system_data = localStorage.getItem('void_system_data');
      if (void_user_data && void_ship_data && void_system_data){
        DataShareService.setUser(  JSON.parse(void_user_data));
        DataShareService.setShip(  JSON.parse(void_ship_data));
        DataShareService.setSystem(JSON.parse(void_system_data));
        return true;
      }
      return false;
    }
  }
})();