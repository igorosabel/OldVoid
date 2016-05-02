(function() {
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
        last_save_point: data.last_save_point
      });
    }
    
    function ClearCredentials(){
      DataShareService.resetUser();
      localStorage.removeItem('void_data');
    }
    
    function SaveLocalstorage(){
      localStorage.setItem('void_data',JSON.stringify(DataShareService.getUser()));
    }
    
    function LoadLocalStorage(){
      var void_data = localStorage.getItem('void_data');
      if (void_data){
        DataShareService.setUser(JSON.parse(void_data));
        return true;
      }
      return false;
    }
  }
})();