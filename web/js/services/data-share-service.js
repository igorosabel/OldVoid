(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('DataShareService', DataShareService);
 
  function DataShareService(){
    var service = {};

    service.globals     = {};
    service.setGlobal   = setGlobal;
    service.getGlobal   = getGlobal;
    service.user        = {};
    service.resetUser   = resetUser;
    service.setUser     = setUser;
    service.getUser     = getUser;
    service.ship        = {};
    service.resetShip   = resetShip;
    service.setShip     = setShip;
    service.getShip     = getShip;
    service.system      = {};
    service.resetSystem = resetSystem;
    service.setSystem   = setSystem;
    service.getSystem   = getSystem;
 
    return service;

    function setGlobal(key,val){
      service.globals[key] = val;
    }
    function getGlobal(key){
      return (service.globals[key]) ? service.globals[key] : null;
    }

    function resetUser(){
      service.user = {};
    }
    function setUser(user){
      service.user = user;
    }
    function getUser(){
      return service.user;
    }

    function resetShip(){
      service.ship = {};
    }
    function setShip(ship){
      service.ship = ship;
    }
    function getShip(){
      return service.ship;
    }

    function resetSystem(){
      service.system = {};
    }
    function setSystem(system){
      service.system = system;
    }
    function getSystem(){
      return service.system;
    }
  }
})();