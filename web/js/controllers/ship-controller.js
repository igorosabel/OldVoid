(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('ShipController', ShipController);

  ShipController.$inject = ['DataShareService', 'APIService'];
  function ShipController(DataShareService, APIService){
    console.log('ShipController');

    var vm = this;

    vm.menu_option  = 'loading';
    vm.ship         = {};
    vm.menu_list    = [];
    vm.storage_list = [];
    vm.module_types = [{id:'small',name:'Pequeños'},{id:'big',name:'Grandes'}];
    
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
      var module_type_ind, module_type, module_ind, module, enables_ind, enables, storage_occupied, resource_ind;
      var loaded = {
        storage: false
      };
      for (module_type_ind in vm.module_types) {
        module_type = vm.module_types[module_type_ind];
        for (module_ind in vm.ship['modules_'+module_type.id]) {
          module = vm.ship['modules_'+module_type.id][module_ind];
          if (module.enables) {
            for (enables_ind in module.enables) {
              enables = module.enables[enables_ind];
              if (enables.id == 'storage') {
                if (!loaded.storage) {
                  vm.menu_list.push({
                    id: 'storage',
                    name: 'Almacenamiento'
                  });
                  loaded.storage = true;
                }
                storage_occupied = 0;
                if (module.storage) {
                  for (resource_ind in module.storage) {
                    storage_occupied += module.storage[resource_ind].value;
                  }
                }
                vm.storage_list.push({
                  id_module: module.id,
                  name: module.module_type_name,
                  storage: module.storage,
                  storage_capacity: module.storage_capacity,
                  storage_occupied: storage_occupied
                });
              }
            }
          }
        }
      }
console.log(vm.storage_list);
      vm.menu_option = 'main';
    });
  }
})();