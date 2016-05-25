(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('LoadingController', LoadingController);

  LoadingController.$inject = ['$timeout', '$location', 'AuthenticationService', 'DataShareService', 'APIService'];
  function LoadingController($timeout, $location, AuthenticationService, DataShareService, APIService){
    console.log('LoadingController');
    if (AuthenticationService.loadLocalStorage() && !DataShareService.GetUser()){
      AuthenticationService.ClearCredentials();
      $location.path('/');
      return false;
    }

    var vm      = this;
    vm.explorer = DataShareService.GetUser();
    vm.status   = {
      ship: 'img/common/loading.svg',
      system: 'img/common/loading.svg'
    };

    loadShip();

    function loadShip() {
      APIService.GetShip(function (response) {
        DataShareService.SetShip(response.ship);
        vm.status.ship = 'img/common/check.svg';
        loadSystem();
      });
    }

    function loadSystem(){
      APIService.GetSystem(vm.explorer.last_save_point,function(response){
        DataShareService.SetSystem(response.system);
        vm.status.system = 'img/common/check.svg';

        DataShareService.SetGlobal('loaded',true);

        $timeout(function(){
          $location.path('/main');
        },1000);
      });
    }
  }
})();