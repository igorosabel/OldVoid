(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('MainController', MainController);

  MainController.$inject = ['$routeParams', '$location', '$mdSidenav', 'AuthenticationService', 'DataShareService'];
  function MainController($routeParams, $location, $mdSidenav, AuthenticationService, DataShareService){
    console.log('MainController');
    if (AuthenticationService.loadLocalStorage() && !DataShareService.GetUser()){
      AuthenticationService.ClearCredentials();
      $location.path('/');
      return false;
    }

    var vm = this;

    vm.tab = {
      main: ($location.path()=='/main'),
      system: ($location.path()=='/system') || ($location.path().substr(0, 8)=='/system/')
    };

    var header_tab = $location.path().substr(1,$location.path().length);
    DataShareService.SetGlobal('tab',header_tab);
    
    if ($routeParams.system_id){
      DataShareService.SetGlobal('system_id',$routeParams.system_id);
    }

    vm.openMenu = openMenu;
    function openMenu(){
      $mdSidenav('leftmenu')
        .toggle();
    }

    vm.logout = logout;
    function logout(){
      AuthenticationService.ClearCredentials();
      $location.path('/');
    }
  }
})();