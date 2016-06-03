(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('PanelController', PanelController);

  PanelController.$inject = ['DataShareService', 'APIService'];
  function PanelController(DataShareService, APIService){
    console.log('PanelController');

    var start_load = DataShareService.GetGlobal('loaded');
    if (!start_load){
      return false;
    }

    var vm = this;

    vm.user   = DataShareService.GetUser();
    vm.ship   = DataShareService.GetShip();
    vm.system = DataShareService.GetSystem();
    vm.notifications    = [];
    vm.people_in_system = [];

    APIService.GetNotifications(function(response){
      vm.notifications = response.notifications;
    });

    APIService.GetPeopleInSystem(vm.system.id,function(response){
      vm.people_in_system = response.people_in_system;
    });
  }
})();