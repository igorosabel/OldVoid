(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('SystemController', SystemController);

  SystemController.$inject = ['DataShareService', 'APIService'];
  function SystemController(DataShareService, APIService){
    console.log('SystemController');

    var vm = this;
    
    vm.system_tab = DataShareService.getGlobal('system_tab');
    if (!vm.system_tab){
      vm.system_tab = 'system';
    }
    
    // Datos
    var explorer_system = DataShareService.getSystem();
    var system_id = DataShareService.getGlobal('system_id');
    var system = {};
    if (!system_id){
      system = DataShareService.getSystem();
      loadSystem();
    }
    else{
      system = DataShareService.getGlobal('system_current');
      if (!system || (system && system.id!=system_id)){
        APIService.GetSystem(system_id,function(response){
          system = response.system;
          loadSystem();
        });
      }
    }
    
    vm.sidebar_list = [];
    for (var i=0;i<system.connections.length;i++){
      if (system.connections[i]===false){
        vm.sidebar_list.push({
          id: (i+1),
          icon: 'system_unknown',
          name: 'Desconocido',
          time: '04:45',
          disabled: false
        });
      }
      else{
        vm.sidebar_list.push({
          id: (i+1),
          icon: 'panel_ico_system',
          name: urldecode(system.connections[i].name),
          time: '04:45',
          disabled: false
        });
      }
    }
    
    function loadSystem(){
      // Sistema
      vm.system_list = [];
      vm.system_style = template('sun_style',{
        width: Math.floor(system.radius / 1000),
        width_half: Math.floor( Math.floor(system.radius / 1000) / 2 ),
        color: urldecode(system.color)
      });
      for (var i=0;i<system.planet_list.length;i++){
        vm.system_list.push({
          id: system.planet_list[i].id,
          name: urldecode(system.planet_list[i].name)
        });
        vm.system_style += template('planet_style',{
          ind: i,
          distance: (180 + (50 * system.planet_list[i].distance)),
          distance_half: Math.floor( (180 + (50 * system.planet_list[i].distance)) / 2 ),
          rotate_time: (Math.random() * (100 - 2) + 2),
          width: (10 * (system.planet_list[i].radius / 10000)),
          width_half: Math.floor( (10 * (system.planet_list[i].radius / 10000)) /2 )
        });
      }
      console.log(vm.system_list);
      document.getElementById('system_style').innerHTML = vm.system_style;
      
      // Sidebar
      vm.system_name = system.name;
      vm.system_type = system.type;
      vm.system_type_desc = 'Enana';
      vm.system_planets = system.planets;
      vm.system_discoverer = system.discoverer;
      vm.system_npcs = system.npc;
      vm.system_hide_jump_to = (system.id==explorer_system.id);
      vm.system_jump_to_time = '02:37';
    }
  }
})();