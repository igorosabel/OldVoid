(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('LoginController', LoginController);

  LoginController.$inject = ['$location', 'AuthenticationService', 'DataShareService', '$mdMedia','WSService'];
  function LoginController($location, AuthenticationService, DataShareService, $mdMedia, WSService){
    console.log('LoginController');
    //WSService.Init();

    if (AuthenticationService.loadLocalStorage()){
      $location.path('/main');
      return false;
    }

    var vm = this;

    vm.login    = login;
    vm.$mdMedia = $mdMedia;

    vm.email = '';
    vm.pass  = '';

    (function initController(){
        AuthenticationService.ClearCredentials();
    })();

    function login() {
      if (vm.email==''){
        alert('¡No puedes dejar el email en blanco!');
        return false;
      }
      if (vm.pass==''){
        alert('¡No puedes dejar la contraseña en blanco!');
        return false;
      }
      
      /*WSService.Login(vm.email, vm.pass, function (response){
        if (response.status=='ok'){
          WSService.DeleteCallback(response.uuid);
          DataShareService.SetAuth(response.auth);
          $location.path('/loading');
        }
      });*/
      
      AuthenticationService.Login(vm.email, vm.pass, function (response){
        if (response.status=='ok'){
          DataShareService.SetAuth(response.auth);
          $location.path('/loading');
        }
      });
    }
  }
})();