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
        name: urldecode(data.name),
        credits: data.credits,
        current_ship: data.current_ship,
        last_save_point: data.last_save_point
      });
    }
    
    function ClearCredentials(){
      DataShareService.ResetUser();
      localStorage.removeItem('void_user_data');
    }
    
    function SaveLocalstorage(){
      var data = {
        auth: DataShareService.GetAuth(),
        user: DataShareService.GetUser()
      };
      localStorage.setItem('void_user_data', JSON.stringify(data));
    }
    
    function LoadLocalStorage(){
      var void_user_data = localStorage.getItem('void_user_data');
      if (void_user_data){
        var data = JSON.parse(void_user_data);
        DataShareService.SetAuth(data.auth);
        DataShareService.SetUser(data.user);
        return true;
      }
      return false;
    }
  }
})();