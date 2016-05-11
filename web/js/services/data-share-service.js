(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('DataShareService', DataShareService);
 
  function DataShareService(){
    var service = {};

    service.globals     = {};
    service.user        = {};
    service.ship        = {};
    service.System      = {};

    service.SetGlobal   = SetGlobal;
    service.GetGlobal   = GetGlobal;
    service.ResetUser   = ResetUser;
    service.SetUser     = SetUser;
    service.GetUser     = GetUser;
    service.ResetShip   = ResetShip;
    service.SetShip     = SetShip;
    service.GetShip     = GetShip;
    service.ResetSystem = ResetSystem;
    service.SetSystem   = SetSystem;
    service.GetSystem   = GetSystem;
 
    return service;

    function SetGlobal(key,val){
      service.globals[key] = val;
    }
    function GetGlobal(key){
      return (service.globals[key]) ? service.globals[key] : null;
    }

    function ResetUser(){
      service.user = {};
    }
    function SetUser(user){
      service.user = user;
    }
    function GetUser(){
      return service.user;
    }

    function ResetShip(){
      service.ship = {};
    }
    function SetShip(ship){
      service.ship = ship;
    }
    function GetShip(){
      return service.ship;
    }

    function ResetSystem(){
      service.system = {};
    }
    function SetSystem(system){
      service.system = system;
    }
    function GetSystem(){
      return service.system;
    }
  }
})();