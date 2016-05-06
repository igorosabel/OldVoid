(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('LoginController', LoginController);

  LoginController.$inject = ['$location', 'AuthenticationService'];
  function LoginController($location, AuthenticationService){
    console.log('LoginController');

    if (AuthenticationService.loadLocalStorage()){
      $location.path('/main');
      return false;
    }

    var vm = this;

    vm.login = login;

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
      AuthenticationService.Login(vm.email, vm.pass, function (response){
        if (response.status=='ok'){
          AuthenticationService.SetCredentials(response);
          AuthenticationService.SaveLocalstorage();
          $location.path('/main');
        }
      });
    }
  }
})();