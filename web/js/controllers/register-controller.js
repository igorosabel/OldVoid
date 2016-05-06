(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('RegisterController', RegisterController);

  RegisterController.$inject = ['$location', 'AuthenticationService'];
  function RegisterController($location, AuthenticationService){
    console.log('RegisterController');

    var vm = this;

    vm.register = register;

    vm.name  = '';
    vm.email = '';
    vm.pass  = '';
    vm.conf  = '';

    function register() {
      if (vm.name==''){
        alert('¡No puedes dejar el nombre de usuario en blanco!');
        return false;
      }
      if (vm.email==''){
        alert('¡No puedes dejar el email en blanco!');
        return false;
      }
      if (vm.pass==''){
        alert('¡No puedes dejar la contraseña en blanco!');
        return false;
      }
      if (vm.conf==''){
        alert('¡No puedes dejar la confirmación de la contraseña en blanco!');
        return false;
      }
      if (vm.pass!=vm.conf){
        alert('¡Las contraseñas introducidas no coinciden!');
        return false;
      }
      AuthenticationService.RegisterExplorer(vm.name, vm.email, vm.pass, function (response){
        if (response.status=='ok') {
          AuthenticationService.SetCredentials(response);
          AuthenticationService.SaveLocalstorage();
          $location.path('/main');
        }
      });
    }
  }
})();