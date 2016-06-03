(function(){
  'use strict';

  angular
    .module('VoidApp')
    .filter('urldecode', urldecodeFilter)
    .filter('showtime', showtimeFilter)
    .filter('formatnumber', formatnumberFilter)
    .filter('yesno', yesnoFilter)
    .filter('wherediscovered', wherediscoveredFilter);

  function urldecodeFilter(){
    return function (str){
      str = urldecode(str);
      return str;
    };
  }

  function showtimeFilter(){
    return function (num){
      var m = Math.floor(num / 60);
      var s = Math.floor(num - (m * 60) );
      return ((m<10)?'0'+m:m)+':'+((s<10)?'0'+s:s);
    };
  }

  function formatnumberFilter(){
    return function (num){
      return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    };
  }

  function yesnoFilter(){
    return function (num){
      return num?'Si':'No';
    };
  }

  function wherediscoveredFilter(){
    return function(where,system){
      var i, j,planet,moon;
      if (where.type=='system'){
        return urldecode(system.name);
      }
      if (where.type=='planet'){
        for (i=0;i<system.planet_list.length;i++){
          planet = system.planet_list[i];
          if (planet.id==where.id){
            if (planet.explored) {
              return urldecode(planet.name);
            }
            else{
              return 'Desconocido';
            }
          }
        }
      }
      if (where.type=='moon'){
        for (i=0;i<system.planet_list.length;i++){
          planet = system.planet_list[i];
          for (j=0;j<planet.moon_list.length;j++){
            moon = planet.moon_list[j];
            if (moon.id==where.id){
              if (moon.explored) {
                return urldecode(moon.name);
              }
              else{
                return 'Desconocido';
              }
            }
          }
        }
      }
      return '';
    };
  }

})();