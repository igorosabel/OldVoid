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
      resources:  []
    };

    vm.selectSystem  = selectSystem;
    vm.selectPlanet  = selectPlanet;
    vm.selectMoon    = selectMoon;
    vm.explorePlanet = explorePlanet;
    vm.exploreMoon   = exploreMoon;
    
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

    // Sistemas vecinos
    for (var i=0;i<vm.selectedSystem.connections.length;i++){
      if (vm.selectedSystem.connections[i]===false){
        vm.sidebar_list.push({
          id: (i+1),
          icon: 'unknown',
          name: 'Desconocido',
          time: '04:45',
          disabled: false
        });
      }
      else{
        vm.sidebar_list.push({
          id: (i+1),
          icon: 'system',
          name: urldecode(vm.selectedSystem.connections[i].name),
          time: '04:45',
          disabled: false
        });
      }
    }

    // Eventos de trabajo terminado: exploración, navegación...
    $rootScope.$on('job_finish', function(event, e){
      switch (e.type){
        // Explorar
        case 1: {
          APIService.GetSystem(vm.selectedSystem.id,function(response){
            
          });
          vm.selectedPlanet.explored = true;

          for (var i=0;i<vm.selectedSystem.planet_list.length;i++){
            if (vm.selectedSystem.planet_list[i].id==vm.selectedPlanet.id){
              vm.selectedSystem.planet_list[i].explored = true;
              break;
            }
          }

          vm.working = DataShareService.GetGlobal('working');
          DataShareService.SetSystem(vm.selectedSystem);
          AuthenticationService.SaveLocalstorage();
        }
        break;
        // Saltar
        case 2: {

        }
        break;
      }
    });

    function loadSystem(){
      // Sistema
      vm.system_list = [];
      vm.system_style = template('sun_style',{
        width: Math.floor(vm.selectedSystem.radius / 1000),
        width_half: Math.floor( Math.floor(vm.selectedSystem.radius / 1000) / 2 ),
        color: urldecode(vm.selectedSystem.color)
      });
      for (var i=0;i<vm.selectedSystem.planet_list.length;i++){
        // Añado el planeta
        vm.system_list.push({
          id: vm.selectedSystem.planet_list[i].id,
          name: urldecode(vm.selectedSystem.planet_list[i].name),
          type: 'planet',
          distance: vm.selectedSystem.planet_list[i].distance,
          radius: vm.selectedSystem.planet_list[i].radius,
          visible: {item: true, walk: true}
        });

        // Añado sus lunas
        console.log('lunas');
        console.log(vm.selectedSystem.planet_list[i]);
        for (var j=0;j<vm.selectedSystem.planet_list[i].moon_list.length;j++){
          vm.system_list.push({
            id: vm.selectedSystem.planet_list[i].moon_list[j].id,
            name: urldecode(vm.selectedSystem.planet_list[i].moon_list[j].name),
            type: 'moon',
            planet_id: vm.selectedSystem.planet_list[i].id,
            distance: vm.selectedSystem.planet_list[i].moon_list[j].distance,
            radius: vm.selectedSystem.planet_list[i].moon_list[j].radius,
            visible: {item: false, walk: false}
          });
        }
      }
      vm.system_style += calculateCSS(vm.system_list);
      console.log(vm.selectedSystem);
      document.getElementById('system_style').innerHTML = vm.system_style;
      
      // Sidebar
      loadInfoBox('system',{
        name: vm.selectedSystem.name,
        type: vm.selectedSystem.type,
        type_desc: 'Enana',
        planets: vm.selectedSystem.planets,
        discoverer: vm.selectedSystem.discoverer,
        npcs: vm.selectedSystem.npc
      });

      vm.system_hide_jump_to = (vm.selectedSystem.id==explorer_system.id);
      vm.system_jump_to_time = '02:37';
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
      var p_obj, planet, i, ind;

      if (p && vm.selectedPlanet){
        return false;
      }

      // Vista de planeta, la quito para volver a sistema
      if (vm.selectedPlanet){
        p_obj = document.getElementById('planet'+ vm.selectedPlanet.id);
        show('sun');

        // Busco el planeta en el sistema
        for (i=0; i<vm.selectedSystem.planet_list.length; i++) {
          planet = vm.selectedSystem.planet_list[i];
          // Si es el indicado me guardo su indice
          if (planet.id == vm.selectedPlanet.id) {
            ind = i;
          }
          else {
            // Si no es el elegido lo muestro
            show('planet' + planet.id);
          }
          // Muestro el recorrido
          show('planet' + planet.id + '_walk');
        }

        // Al planeta elegido le quito zoom
        p_obj.classList.remove('planet_zoomed');
        vm.system_name = vm.selectedSystem.name;

        // Muestro sus lunas
        for (i=0; i<vm.selectedSystem.planet_list[ind].moon_list.length; i++) {
          hide('moon' + vm.selectedSystem.planet_list[ind].moon_list[i].id);
          hide('moon' + vm.selectedSystem.planet_list[ind].moon_list[i].id + '_walk');
        }

        vm.system_view = 'system';
        vm.selectedPlanet = null;
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
      else {
        p_obj = document.getElementById('planet'+ p.id);
        hide('sun');

        // Busco el planeta en el sistema
        for (i=0; i<vm.selectedSystem.planet_list.length; i++) {
          planet = vm.selectedSystem.planet_list[i];
          // Si es el indicado me guardo su indice
          if (planet.id == p.id) {
            ind = i;
          }
          else {
            // Si no es el elegido lo escondo
            hide('planet' + planet.id);
          }
          // Escondo el recorrido
          hide('planet' + planet.id + '_walk');
        }
        planet = vm.selectedSystem.planet_list[ind];

        // Al planeta elegido le hago zoom
        p_obj.classList.add('planet_zoomed');
        vm.system_name = p.name;

        // Muestro sus lunas
        for (i=0; i<planet.moon_list.length; i++) {
          show('moon' + planet.moon_list[i].id);
          show('moon' + planet.moon_list[i].id + '_walk');
        }

        vm.system_view = 'planet';
        vm.selectedPlanet = planet;
        loadInfoBox('planet',{
          name: planet.name,
          type: planet.type,
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
        m_obj = document.getElementById('moon'+ vm.selectedMoon.id);

        // Busco la luna en el planeta
        for (i=0; i<vm.selectedPlanet.moon_list.length; i++) {
          moon = vm.selectedPlanet.moon_list[i];
          // Si es la indicada me guardo su indice
          if (moon.id == vm.selectedMoon.id) {
            ind = i;
          }
          else {
            // Si no es la elegida la muestro
            show('moon' + moon.id);
          }
          // Muestro el recorrido
          show('moon' + moon.id + '_walk');
        }

        // A la luna elegida le quito zoom
        m_obj.classList.remove('planet_zoomed');
        show('planet'+ vm.selectedPlanet.id);
        vm.system_name = vm.selectedPlanet.name;

        vm.system_view = 'planet';
        vm.selectedMoon = null;
        loadInfoBox('planet',{
          name: vm.selectedPlanet.name,
          type: vm.selectedPlanet.type,
          radius: vm.selectedPlanet.radius,
          survival: vm.selectedPlanet.survival,
          has_life: (vm.selectedPlanet.has_life?'Si':'No'),
          moons: vm.selectedPlanet.moon_list.length
        });
      }
      // Vista de planeta, pongo vista de luna
      else {
        m_obj = document.getElementById('moon'+ m.id);
        hide('planet'+ vm.selectedPlanet.id);

        // Busco la luna en el planeta
        for (i=0; i<vm.selectedPlanet.moon_list.length; i++) {
          moon = vm.selectedPlanet.moon_list[i];
          // Si es el indicado me guardo su indice
          if (moon.id == m.id) {
            ind = i;
          }
          else {
            // Si no es el elegido lo escondo
            hide('moon' + moon.id);
          }
          // Escondo el recorrido
          hide('moon' + moon.id + '_walk');
        }
        moon = vm.selectedPlanet.moon_list[ind];

        // A la luna elegida le hago zoom
        m_obj.classList.add('planet_zoomed');
        vm.system_name = m.name;

        vm.system_view = 'moon';
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
        vm.info_box.type_desc  = obj.type_desc;
        vm.info_box.planets    = obj.planets;
        vm.info_box.discoverer = obj.discoverer;
        vm.info_box.npcs       = obj.npcs;
      }
      if (vm.info_box.view=='planet'){
        vm.info_box.name     = obj.name;
        vm.info_box.type     = obj.type;
        vm.info_box.radius   = obj.radius;
        vm.info_box.survival = obj.survival;
        vm.info_box.has_life = obj.has_life;
        vm.info_box.moons    = obj.moons;
      }
      if (vm.info_box.view=='moon'){
        vm.info_box.name     = obj.name;
        vm.info_box.radius   = obj.radius;
        vm.info_box.survival = obj.survival;
        vm.info_box.has_life = obj.has_life;
      }
    }

    function calculateCSS(list){
      var css = '';
      var item;
      for (var i=0;i<list.length;i++){
        item = list[i];
        css += template(item.type+'_style',{
          id: item.id,
          distance: (180 + (50 * item.distance)),
          distance_half: Math.floor( (180 + (50 * item.distance)) / 2 ),
          rotate_time: (Math.random() * (100 - 2) + 2),
          width: (10 * (item.radius / 10000)),
          width_half: Math.floor( (10 * (item.radius / 10000)) /2 ),
          visible: (item.type=='planet')?'block':'none'
        });
      }

      return css;
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
        }
      });
    }

    function exploreMoon(){
      APIService.Explore(vm.selectedMoon.id, 'moon', function(response){
        vm.selectedMoon.explored = true;

        var found = false;
        for (var i=0;i<vm.selectedSystem.planet_list.length;i++){
          for (var j=0;j<vm.selectedSystem.planet_list[i].moon_list.length;j++){
            if (vm.selectedSystem.planet_list[i].moon_list[j].id==vm.selectedMoon.id){
              vm.selectedSystem.planet_list[i].moon_list[j].explored = true;
              found = true;
              break;
            }
          }
          if (found){ break; }
        }

        DataShareService.SetSystem(vm.selectedSystem);
        AuthenticationService.SaveLocalstorage();
      });
    }
  }
})();