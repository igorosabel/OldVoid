(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('ShipController', ShipController);

  ShipController.$inject = ['DataShareService', 'APIService'];
  function ShipController(DataShareService, APIService){
    console.log('ShipController');

    var vm = this;

    vm.menu_option = 'loading';
    vm.ship = {};
    vm.menu_list = [];
    
    vm.selectMenuOption = selectMenuOption;
    vm.range            = range;
    loadMenuList();

    function loadMenuList(){
      vm.menu_list.push({
        id: 'main',
        name: 'Nave actual'
      });
      vm.menu_list.push({
        id: 'guns',
        name: 'Armas'
      });
      vm.menu_list.push({
        id: 'modules',
        name: 'Módulos'
      });
    }

    function selectMenuOption(id){
      vm.menu_option = id;
    }

    APIService.GetShip(function(response){
      vm.ship = response.ship;

      // Cargo "habilidades" de los módulos
      var i,j;
      var loaded = {
        storage: false
      };
      for (i=0;i<vm.ship.modules_small.length;i++) {
        if (vm.ship.modules_small[i].enables) {
          for (j = 0; j < vm.ship.modules_small[i].enables.length; j++) {
            if (!loaded.storage && vm.ship.modules_small[i].enables[j].id == 'storage') {
              vm.menu_list.push({
                id: 'storage',
                name: 'Almacenamiento'
              });
              loaded.storage = true;
            }
          }
        }
      }
      for (i=0;i<vm.ship.modules_big.length;i++) {
        if (vm.ship.modules_big[i].enables) {
          for (j = 0; j < vm.ship.modules_big[i].enables.length; j++) {
            if (!loaded.storage && vm.ship.modules_big[i].enables[j].id == 'storage') {
              vm.menu_list.push({
                id: 'storage',
                name: 'Almacenamiento'
              });
              loaded.storage = true;
            }
          }
        }
      }

      vm.menu_option = 'main';
    });
  }
})();