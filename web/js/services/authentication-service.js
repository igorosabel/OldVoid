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
        auth: data.auth,
        current_ship: data.current_ship,
        last_save_point: data.last_save_point
      });
    }
    
    function ClearCredentials(){
      DataShareService.ResetUser();
      localStorage.removeItem('void_user_data');
    }
    
    function SaveLocalstorage(){
      localStorage.setItem('void_user_data', JSON.stringify(DataShareService.GetUser()));
    }
    
    function LoadLocalStorage(){
      var void_user_data = localStorage.getItem('void_user_data');
      if (void_user_data){
        DataShareService.SetUser(JSON.parse(void_user_data));
        return true;
      }
      return false;
    }
  }
})();