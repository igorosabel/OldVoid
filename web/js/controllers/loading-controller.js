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
    vm.status   = {
      explorer: 'img/common/loading.svg',
      ship: 'img/common/loading.svg',
      system: 'img/common/loading.svg'
    };

    checkExplorer();

    function checkExplorer(){
      APIService.CheckExplorer(function (response) {
        if (response.status=='ok'){
          AuthenticationService.SetCredentials(response.explorer);
          AuthenticationService.SaveLocalstorage();
          vm.status.explorer = 'img/common/check.svg';
          loadShip();
        }
        else{
          AuthenticationService.ClearCredentials();
          $location.path('/');
        }
      });
    }

    function loadShip() {
      APIService.GetShip(function (response) {
        DataShareService.SetShip(response.ship);
        vm.status.ship = 'img/common/check.svg';
        loadSystem();
      });
    }

    function loadSystem(){
      APIService.GetSystem(DataShareService.GetUser().last_save_point,function(response){
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