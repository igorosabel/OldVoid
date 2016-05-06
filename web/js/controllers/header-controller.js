(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('HeaderController', HeaderController);

  HeaderController.$inject = ['$location', 'AuthenticationService', 'DataShareService'];
  function HeaderController($location, AuthenticationService, DataShareService){
    console.log('HeaderController');

    var vm = this;

    vm.logout = logout;

    vm.explorer_name = DataShareService.getUser().name;
    vm.tab = DataShareService.globals.tab;

    function logout(){
      AuthenticationService.ClearCredentials();
      $location.path('/');
    }
  }
})();