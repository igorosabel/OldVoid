(function(){
  'use strict';

  angular
    .module('VoidApp')
    .controller('SystemController', SystemController);

  SystemController.$inject = ['$rootScope','$mdDialog', 'DataShareService', 'APIService', 'JobService', 'AuthenticationService'];
  function SystemController($rootScope, $mdDialog, DataShareService, APIService, JobService, AuthenticationService){
    console.log('SystemController');

    var vm = this;
    
    vm.system_tab = DataShareService.GetGlobal('system_tab');
    if (!vm.system_tab){
      vm.system_tab = 'system';
    }

    vm.system_view    = 'system';
    vm.system_id      = DataShareService.GetGlobal('system_id');
    vm.sidebar_list   = [];
    vm.working        = DataShareService.GetGlobal('working');
    vm.selectedSystem = null;
    vm.selectedPlanet = null;
    vm.selectedMoon   = null;
    vm.system_list    = [];
    vm.system_style   = '';
    vm.info_box = {
      view:       'system',
      show_main:  true,
      name:       '',
      type:       '',
      desc:       '',
      planets:    0,
      discoverer: '',
      npcs:       0,
      radius:     0,
      survival:   0,
      has_life:   'No',
      moons:      0,
      resources:  [],
      has_sub:    true,
      show_sub:   true,
      sub_name:   ''
    };

    vm.toggleInfoBox      = toggleInfoBox;
    vm.selectSystem       = selectSystem;
    vm.selectPlanet       = selectPlanet;
    vm.selectMoon         = selectMoon;
    vm.explorePlanet      = explorePlanet;
    vm.exploreMoon        = exploreMoon;
    vm.getResourcesPlanet = getResourcesPlanet;
    vm.getResourcesMoon   = getResourcesMoon;
    vm.goToSystem         = goToSystem;
    
    // Datos
    var explorer_system = DataShareService.GetSystem();
    vm.selectedSystem = {};
    if (!vm.system_id){
      vm.selectedSystem = DataShareService.GetSystem();
      loadSystem();
    }
    else{
      vm.selectedSystem = DataShareService.GetGlobal('system_current');
      if (!vm.selectedSystem || (vm.selectedSystem && vm.selectedSystem.id!=vm.system_id)){
        APIService.GetSystem(vm.system_id,function(response){
          vm.selectedSystem = response.system;
          loadSystem();
        });
      }
    }
console.log(vm.selectedSystem);

    // Eventos de trabajo terminado: exploración, navegación...
    $rootScope.$on('job_finish', function(event, e){
      switch (e.type){
        // Explorar
        case 1: {
          reloadSystem();
        }
        break;
        // Saltar
        case 2: {
          jumpComplete(e);
        }
        break;
        // Obtener recursos
        case 3: {
          reloadSystem();
        }
        break;
      }
    });

    function loadSystem(){
      // Sistema
      vm.system_list = [];
      var sun_obj = {
        type: 'sun',
        radius: vm.selectedSystem.radius,
        color: urldecode(vm.selectedSystem.color)
      };
      vm.system_style = '';
      for (var i=0;i<vm.selectedSystem.planet_list.length;i++){
        // Añado el planeta
        vm.system_list.push({
          id: vm.selectedSystem.planet_list[i].id,
          name: urldecode(vm.selectedSystem.planet_list[i].name),
          type: 'planet',
          distance: vm.selectedSystem.planet_list[i].distance,
          radius: vm.selectedSystem.planet_list[i].radius,
          rotation: vm.selectedSystem.planet_list[i].rotation
        });
      }
      vm.system_style = calculateCSS(sun_obj,vm.system_list);
      document.getElementById('system_style').innerHTML = vm.system_style;
      
      // Sidebar
      loadInfoBox('system',{
        name: vm.selectedSystem.name,
        type: vm.selectedSystem.type,
        type_name: urldecode(vm.selectedSystem.type_name),
        planets: vm.selectedSystem.planets,
        discoverer: vm.selectedSystem.discoverer,
        npcs: vm.selectedSystem.npc
      });

      vm.system_hide_jump_to = (vm.selectedSystem.id==explorer_system.id);
      vm.system_jump_to_time = '02:37';
      loadConnections();
    }
    
    function reloadSystem(jump){
      // Comprobación por si se trata de reload tras saltar
      if (typeof jump == 'undefined'){
        jump = false;
      }
      var user = DataShareService.GetUser();
      var current = {
        system: user.last_save_point,
        planet: (vm.selectedPlanet)?vm.selectedPlanet.id:null,
        moon: (vm.selectedMoon)?vm.selectedMoon.id:null
      };
      APIService.GetSystem(current.system,function(response){
        vm.selectedSystem = response.system;
        
        var planet_ind = -1;
        var moon_ind   = -1;
        var i;
        
        if (current.planet){
          for (i=0;i<vm.selectedSystem.planet_list.length;i++){
            if (vm.selectedSystem.planet_list[i].id==current.planet){
              planet_ind = i;
              break;
            }
          }
          vm.selectedPlanet = vm.selectedSystem.planet_list[planet_ind];
        }
        
        if (current.moon){
          for (i=0;i<vm.selectedPlanet.moon_list.length;i++){
            if (vm.selectedPlanet.moon_list[i].id==current.moon){
              moon_ind = i;
              break;
            }
          }
          vm.selectedMoon = vm.selectedPlanet.moon_list[moon_ind];
        }

        if (jump){
          explorer_system = DataShareService.GetSystem();
          vm.system_view = 'system';
          loadSystem();
        }
        
        vm.working = DataShareService.GetGlobal('working');
        DataShareService.SetSystem(vm.selectedSystem);
        AuthenticationService.SaveLocalstorage();
      });
    }

    function loadConnections() {
      vm.sidebar_list = [];
      for (var i = 0; i < vm.selectedSystem.connections.length; i++) {
        if (!vm.selectedSystem.connections[i].id) {
          vm.sidebar_list.push({
            id: null,
            icon: 'unknown',
            name: 'Desconocido',
            time: vm.selectedSystem.connections[i].time,
            disabled: false
          });
        }
        else {
          vm.sidebar_list.push({
            id: vm.selectedSystem.connections[i].id,
            icon: 'system',
            name: urldecode(vm.selectedSystem.connections[i].name),
            time: vm.selectedSystem.connections[i].time,
            disabled: false
          });
        }
      }
    }

    function jumpComplete(job){
      var user = DataShareService.GetUser();
      user.last_save_point = job.value.id;
      DataShareService.SetUser(user);
      AuthenticationService.SaveLocalstorage();

      reloadSystem(true);
    }

    function toggleInfoBox(id){
      vm.info_box['show_'+id] = !vm.info_box['show_'+id];
    }

    function selectSystem(item){
      if (item.type=='planet'){
        selectPlanet(item);
      }
      if (item.type=='moon'){
        selectMoon(item);
      }
    }

    function selectPlanet(p){
      var p_obj, planet, moon, i, ind;

      if (p && vm.selectedPlanet){
        return false;
      }

      // Vista de planeta, la quito para volver a sistema
      if (vm.selectedPlanet){
        // Sistema
        vm.system_list = [];
        var sun_obj = {
          type: 'sun',
          radius: vm.selectedSystem.radius,
          color: urldecode(vm.selectedSystem.color)
        };
        vm.system_style = '';
        for (i=0;i<vm.selectedSystem.planet_list.length;i++){
          planet = vm.selectedSystem.planet_list[i];
          // Añado el planeta
          vm.system_list.push({
            id: planet.id,
            name: urldecode(planet.name),
            type: 'planet',
            distance: planet.distance,
            radius: planet.radius,
            rotation: planet.rotation
          });
        }
        vm.system_style = calculateCSS(sun_obj,vm.system_list);
        document.getElementById('system_style').innerHTML = vm.system_style;

        vm.system_name = vm.selectedSystem.name;

        vm.system_view    = 'system';
        vm.selectedPlanet = null;
        vm.selectedMoon   = null;
        loadInfoBox('system',{
          name: vm.selectedSystem.name,
          type: vm.selectedSystem.type,
          type_desc: 'Enana',
          planets: vm.selectedSystem.planets,
          discoverer: vm.selectedSystem.discoverer,
          npcs: vm.selectedSystem.npc
        });
      }
      // Vista de sistema, pongo vista de planeta
      else{
        // Busco el planeta en el sistema
        for (i=0; i<vm.selectedSystem.planet_list.length; i++) {
          planet = vm.selectedSystem.planet_list[i];
          // Si es el indicado me guardo su indice
          if (planet.id == p.id) {
            ind = i;
            break;
          }
        }
        planet = vm.selectedSystem.planet_list[ind];

        vm.system_list = [];
        var planet_obj = {
          type: 'planet',
          radius: planet.radius,
          color: '#888'
        };
        vm.system_style = '';
        for (i=0;i<planet.moon_list.length;i++){
          moon = planet.moon_list[i];
          // Añado la luna
          vm.system_list.push({
            id: moon.id,
            name: urldecode(moon.name),
            type: 'moon',
            distance: moon.distance,
            radius: moon.radius,
            rotation: moon.rotation
          });
        }
        vm.system_style = calculateCSS(planet_obj,vm.system_list);
        document.getElementById('system_style').innerHTML = vm.system_style;

        vm.system_name = planet.name;

        vm.system_view    = 'planet';
        vm.selectedPlanet = planet;
        vm.selectedMoon   = null;
        loadInfoBox('planet',{
          name: planet.name,
          type: planet.type,
          type_name: urldecode(planet.type_name),
          radius: planet.radius,
          survival: planet.survival,
          has_life: (planet.has_life?'Si':'No'),
          moons: planet.moon_list.length
        });
      }
    }

    function selectMoon(m){
      var p_obj, m_obj, planet, moon, i, ind;

      if (m && vm.selectedMoon){
        return false;
      }

      // Vista de luna, la quito para volver a planeta
      if (vm.selectedMoon){
        planet = vm.selectedPlanet;
        vm.system_list = [];
        var planet_obj = {
          type: 'planet',
          radius: planet.radius,
          color: '#888'
        };
        vm.system_style = '';
        for (i=0;i<planet.moon_list.length;i++){
          moon = planet.moon_list[i];
          // Añado la luna
          vm.system_list.push({
            id: moon.id,
            name: urldecode(moon.name),
            type: 'moon',
            distance: moon.distance,
            radius: moon.radius,
            rotation: moon.rotation
          });
        }
        vm.system_style = calculateCSS(planet_obj,vm.system_list);
        document.getElementById('system_style').innerHTML = vm.system_style;

        vm.system_name = planet.name;

        vm.system_view    = 'planet';
        vm.selectedPlanet = planet;
        vm.selectedMoon   = null;
        loadInfoBox('planet',{
          name: planet.name,
          type: planet.type,
          type_name: urldecode(planet.type_name),
          radius: planet.radius,
          survival: planet.survival,
          has_life: (planet.has_life?'Si':'No'),
          moons: planet.moon_list.length
        });
      }
      // Vista de planeta, pongo vista de luna
      else {
        // Busco la luna en el planeta
        for (i=0; i<vm.selectedPlanet.moon_list.length; i++) {
          moon = vm.selectedPlanet.moon_list[i];
          // Si es el indicado me guardo su indice
          if (moon.id == m.id) {
            ind = i;
            break;
          }
        }
        moon = vm.selectedPlanet.moon_list[ind];

        vm.system_list = [];
        var moon_obj = {
          type: 'moon',
          radius: moon.radius,
          color: '#fff'
        };
        vm.system_style = '';

        vm.system_style = calculateCSS(moon_obj,vm.system_list);
        document.getElementById('system_style').innerHTML = vm.system_style;

        vm.system_name = moon.name;

        vm.system_view  = 'moon';
        vm.selectedMoon = moon;
        loadInfoBox('moon',{
          name: moon.name,
          radius: moon.radius,
          survival: moon.survival,
          has_life: (moon.has_life?'Si':'No')
        });
      }
    }

    function loadInfoBox(view,obj){
      vm.info_box.view = view;
      if (vm.info_box.view=='system'){
        vm.info_box.name       = obj.name;
        vm.info_box.type       = obj.type;
        vm.info_box.type_name  = obj.type_name;
        vm.info_box.planets    = obj.planets;
        vm.info_box.discoverer = obj.discoverer;
        vm.info_box.npcs       = obj.npcs;
        vm.info_box.has_sub    = true;
        vm.info_box.sub_name   = 'Planetas';
      }
      if (vm.info_box.view=='planet'){
        vm.info_box.name      = obj.name;
        vm.info_box.type      = obj.type;
        vm.info_box.type_name = obj.type_name;
        vm.info_box.radius    = obj.radius;
        vm.info_box.survival  = obj.survival;
        vm.info_box.has_life  = obj.has_life;
        vm.info_box.moons     = obj.moons;
        vm.info_box.has_sub   = true;
        vm.info_box.sub_name  = 'Lunas';
      }
      if (vm.info_box.view=='moon'){
        vm.info_box.name     = obj.name;
        vm.info_box.radius   = obj.radius;
        vm.info_box.survival = obj.survival;
        vm.info_box.has_life = obj.has_life;
        vm.info_box.has_sub  = false;
      }
    }

    function calculateCSS(main,list){
      var css          = '';
      var css_distance = '';
      var css_radius   = '';
      var main_radius  = -1;
      var item         = null;
      var i            = null;
      var css_vars     = {};
      
      if (main.type=='sun'){
        main_radius = (main.radius * (700 * 0.2)) / 150000;
        console.log('main.radius: '+main.radius+' - main_radius: '+main_radius);

        css_vars = getCssVars(list);
        css = template('sun_style',{
          width: main_radius,
          width_half: (main_radius / 2),
          color: main.color
        });
        
        for (i=0;i<list.length;i++){
          item = list[i];
          css_distance = (item.distance * css_vars.distance_step);
          css_radius = (item.radius / css_vars.list_km_px);
          console.log(item);
          console.log('css_distance: '+css_distance+' - css_radius: '+css_radius);
          css += template('planet_style',{
            id: item.id,
            distance: css_distance,
            distance_half: Math.floor( css_distance / 2 ),
            rotate_time: item.rotation,
            width: css_radius,
            width_half: Math.floor( css_radius / 2 )
          });
        }
      }
      if (main.type=='planet'){
        main_radius = (main.radius * (700 * 0.2)) / 100000;
        console.log('main.radius: '+main.radius+' - main_radius: '+main_radius);

        css_vars = getCssVars(list);
        css = template('sun_style',{
          width: main_radius,
          width_half: (main_radius / 2),
          color: '#888'
        });

        for (i=0;i<list.length;i++){
          item = list[i];
          css_distance = (item.distance * css_vars.distance_step);
          css_radius = (item.radius / css_vars.list_km_px);
          console.log(item);
          console.log('css_distance: '+css_distance+' - css_radius: '+css_radius);
          css += template('moon_style',{
            id: item.id,
            distance: css_distance,
            distance_half: Math.floor( css_distance / 2 ),
            rotate_time: item.rotation,
            width: css_radius,
            width_half: Math.floor( css_radius / 2 )
          });
        }
      }
      if (main.type=='moon'){
        main_radius = (main.radius * (700 * 0.2)) / 66666;
        console.log('main.radius: '+main.radius+' - main_radius: '+main_radius);

        css = template('sun_style',{
          width: main_radius,
          width_half: (main_radius / 2),
          color: '#fff'
        });
      }

      return css;
    }

    function getCssVars(list){
      var i, item, item_next;
      var ret = {
        max_distance: -1,
        max_list_km: -1,
        distance_step: 1,
        max_separation: 1,
        max_radius_px: -1,
        list_km_px: -1
      };

      // Busco max distance y max_planet_km
      for (i=0;i<list.length;i++){
        item = list[i];

        if (item.distance>ret.max_distance){
          ret.max_distance = item.distance;
        }
        if (item.radius>ret.max_list_km){
          ret.max_list_km = item.radius;
        }
      }

      ret.distance_step  = ( (700 * 0.4) / ret.max_distance );
      console.log('max_distance: '+ret.max_distance+' - max_list_km: '+ret.max_list_km+' - distance_step: '+ret.distance_step);

      // busco max_separation
      for(i=0;i<list.length;i++){
        if (list[i+1]){
          item      = list[i];
          item_next = list[i+1];

          if (ret.max_separation < (item_next.distance-item.distance)){
            ret.max_separation = (item_next.distance-item.distance);
          }
        }
      }

      ret.max_radius_px = (ret.max_separation * ret.distance_step) / 2;
      ret.list_km_px = ret.max_list_km / ret.max_radius_px;

      return ret;
    }

    function explorePlanet(ev){
      APIService.Explore(vm.selectedPlanet.id, 'planet', function(response){
        
        if (response.status=='working'){
          $mdDialog.show(
            $mdDialog.alert()
            .clickOutsideToClose(true)
            .title('Trabajando...')
            .textContent('Actualmente estás realizando otro trabajo. Tendrás que esperar a que acabe para poder explorar este planeta.')
            .ariaLabel('Trabajando...')
            .ok('Entendido')
            .targetEvent(ev)
          );
        }
        else{
          JobService.AddJob(response.job);
          vm.working = true;
        }
      });
    }

    function exploreMoon(){
      APIService.Explore(vm.selectedMoon.id, 'moon', function(response){

        if (response.status=='working'){
          $mdDialog.show(
            $mdDialog.alert()
              .clickOutsideToClose(true)
              .title('Trabajando...')
              .textContent('Actualmente estás realizando otro trabajo. Tendrás que esperar a que acabe para poder explorar esta luna.')
              .ariaLabel('Trabajando...')
              .ok('Entendido')
              .targetEvent(ev)
          );
        }
        else{
          JobService.AddJob(response.job);
          vm.working = true;
        }
      });
    }
    
    function getResourcesPlanet(ev){
      APIService.GetResources(vm.selectedPlanet.id, 'planet', function(response){
        
        if (response.status=='working'){
          $mdDialog.show(
            $mdDialog.alert()
            .clickOutsideToClose(true)
            .title('Trabajando...')
            .textContent('Actualmente estás realizando otro trabajo. Tendrás que esperar a que acabe para poder explorar este planeta.')
            .ariaLabel('Trabajando...')
            .ok('Entendido')
            .targetEvent(ev)
          );
        }
        else{
          JobService.AddJob(response.job);
          vm.working = true;
        }
      });
    }

    function getResourcesMoon(){
      APIService.GetResources(vm.selectedMoon.id, 'moon', function(response){

        if (response.status=='working'){
          $mdDialog.show(
            $mdDialog.alert()
              .clickOutsideToClose(true)
              .title('Trabajando...')
              .textContent('Actualmente estás realizando otro trabajo. Tendrás que esperar a que acabe para poder explorar esta luna.')
              .ariaLabel('Trabajando...')
              .ok('Entendido')
              .targetEvent(ev)
          );
        }
        else{
          JobService.AddJob(response.job);
          vm.working = true;
        }
      });
    }

    function goToSystem(id,time){
      APIService.GoToSystem(id, time, function(response){

        if (response.status=='working'){
          $mdDialog.show(
            $mdDialog.alert()
              .clickOutsideToClose(true)
              .title('Trabajando...')
              .textContent('Actualmente estás realizando otro trabajo. Tendrás que esperar a que acabe para poder explorar esta luna.')
              .ariaLabel('Trabajando...')
              .ok('Entendido')
              .targetEvent(ev)
          );
        }
        else{
          JobService.AddJob(response.job);
          vm.working = true;
        }
      });
    }
  }
})();