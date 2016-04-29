'use strict';

// !Login Controller
// **********************************************************************************************************************************
angular
  .module('VoidApp')
  .controller('LoginController', LoginController);

LoginController.$inject = ['$location', 'AuthenticationService'];
function LoginController($location, AuthenticationService){
  console.log('LoginController');

  if (AuthenticationService.loadLocalStorage()){
    $location.path('/home');
    return false;
  }

  var vm = this;

  vm.login        = login;
  vm.goToRegister = goToRegister;

  (function initController(){
      // reset login status
      AuthenticationService.ClearCredentials();
  })();

  function login() {
    AuthenticationService.Login(vm.login_email, vm.login_pass, function (response){
      if (response.status=='ok') {
        AuthenticationService.SetCredentials(response);
        AuthenticationService.SaveLocalstorage();
        $location.path('/home');
      }
    });
  }
  
  function goToRegister(){
    $location.path('/register');
  }
}
/*********************************************************************************************************************************/