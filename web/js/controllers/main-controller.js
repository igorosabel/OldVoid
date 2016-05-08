(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('MainController', MainController);

  MainController.$inject = ['$routeParams', '$location', 'AuthenticationService', 'DataShareService'];
  function MainController($routeParams, $location, AuthenticationService, DataShareService){
    console.log('MainController');
    if (AuthenticationService.loadLocalStorage() && !DataShareService.getUser()){
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
    DataShareService.setGlobal('tab',header_tab);
    
    if ($routeParams.system_id){
      DataShareService.setGlobal('system_id',$routeParams.system_id);
    }
  }
})();