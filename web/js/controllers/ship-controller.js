(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('ShipController', ShipController);

  ShipController.$inject = ['DataShareService', 'APIService', '$mdDialog', '$mdMedia'];
  function ShipController(DataShareService, APIService, $mdDialog, $mdMedia){
    console.log('ShipController');

    var vm = this;

    vm.menu_option  = 'loading';
    vm.ship         = DataShareService.GetShip();
    vm.menu_list    = [];
    vm.storage_list = [];
    vm.module_types = [{id:'small',name:'Pequeños'},{id:'big',name:'Grandes'}];
    vm.customFullscreen = $mdMedia('xs') || $mdMedia('sm');
    
    vm.selectMenuOption = selectMenuOption;
    vm.range            = range;
    vm.editShipName     = editShipName;
    vm.removeGun        = removeGun;
    vm.addGun           = addGun;

    loadMenuList();
    loadEnables();

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

    function loadEnables() {
      // Cargo "habilidades" de los módulos
      var module_type_ind, module_type, module_ind, module, enables_ind, enables, storage_occupied, resource_ind;
      var loaded = {
        storage: false
      };
      for (module_type_ind in vm.module_types) {
        module_type = vm.module_types[module_type_ind];
        for (module_ind in vm.ship['modules_' + module_type.id]) {
          module = vm.ship['modules_' + module_type.id][module_ind];
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
    }

    function editShipName(ev){
      var useFullScreen = ($mdMedia('sm') || $mdMedia('xs'))  && vm.customFullscreen;
      $mdDialog.show({
          locals: {name: vm.ship.name},
          controller: ShipNameChangeController,
          controllerAs: 'vm',
          templateUrl: 'partials/change_ship_name.html',
          parent: angular.element(document.body),
          targetEvent: ev,
          clickOutsideToClose:true,
          fullscreen: useFullScreen
        })
        .then(function(name) {
          // respuesta
          vm.ship.name = urlencode(name);
          APIService.ChangeShipName(vm.ship.name,function(response){
            if (response.status=='error'){
              alert('¡Ocurrió un error al cambiar el nombre de tu nave!');
            }
          });
        }, function() {
          // cancelar
        });
    }
  }

  function ShipNameChangeController($mdDialog, name) {
    var vm = this;
    vm.name = urldecode(name);

    vm.hide = function() {
      $mdDialog.hide();
    };
    vm.cancel = function() {
      $mdDialog.cancel();
    };
    vm.save = function() {
      $mdDialog.hide(vm.name);
    };
  }

  function removeGun(ev,ind){
    var gun = vm.ship.guns[ind];
    var confirm = $mdDialog.confirm()
      .title('Desequipar arma')
      .textContent('¿Estás seguro de querer desequipar este '+urldecode(gun.gun_type_name)+'?')
      .ariaLabel('Desequipar arma')
      .targetEvent(ev)
      .ok('Continuar')
      .cancel('Cancelar');
    $mdDialog.show(confirm).then(function() {
      alert('quitar');
    }, function() {
      //Cancelar
    });
  }

  function addGun(n){

  }
})();