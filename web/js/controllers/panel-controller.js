(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('PanelController', PanelController);

  PanelController.$inject = ['DataShareService', 'APIService'];
  function PanelController(DataShareService, APIService){
    console.log('PanelController');

    var vm = this;

    var user   = DataShareService.getUser();
    var ship   = DataShareService.getShip();
    var system = DataShareService.getSystem();

    vm.user_id = user.id;

    vm.panel_info = {
      system: system.name,
      credits: user.credits,
      system_type: system.type,
      ship_strength: ship.strength,
      num_planets: system.planets,
      fuel: ship.fuel,
      explorers: system.explorers,
      npc: system.npc
    };

    vm.notifications = [];
    APIService.GetNotifications(function(response){
      vm.notifications = response.notifications;
    });

    vm.people_in_system = [];
    APIService.GetPeopleInSystem(system.id,function(response){
      vm.people_in_system = response.people_in_system;
    });
  }
})();