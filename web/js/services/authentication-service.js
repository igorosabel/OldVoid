(function() {
  'use strict';

  angular
    .module('VoidApp')
    .factory('AuthenticationService', AuthenticationService);
 
  AuthenticationService.$inject = ['$http','$location'];
  function AuthenticationService($http,$location){
    var service = {};
 
    service.Login             = Login;
    service.SetCredentials    = SetCredentials;
    service.ClearCredentials  = ClearCredentials;
    service.RegisterUser      = RegisterUser;
    service.SaveLocalstorage  = SaveLocalstorage;
    service.loadLocalStorage  = LoadLocalStorage;
    service.Logout            = Logout;
 
    return service;
 
    function Login(email, pass, callback){
      $http.post(api_url+'checkLogin', { email: email, pass: pass })
        .success(function (response) {
          callback(response);
        });
    }
 
    function SetCredentials(data){
      angular.voidgame.user = {
        id: data.id_user,
        name: urldecode(data.name),
        email: urldecode(data.email),
        credits: data.credits,
        last_save_point: data.last_save_point
      };
    }
    
    function SaveLocalstorage(){
      localStorage.setItem('void_data',JSON.stringify(angular.voidgame.user));
    }
    
    function LoadLocalStorage(){
      var void_data = localStorage.getItem('void_data');
      if (void_data){
        angular.voidgame.user = JSON.parse(void_data);
        return true;
      }
      return false;
    }
 
    function ClearCredentials(){
      angular.voidgame = {};
      angular.voidgame.user = {};
      localStorage.removeItem('void_data');
    }
    
    function RegisterUser(user, email, pass, callback){
      $http.post(api_url+'register', { user: user, email: email, pass: pass })
        .success(function (response) {
          Login(email, pass, callback);
        });
    }
    
    function Logout(){
      ClearCredentials();
  
      $location.path('/');
    }
  }
})();