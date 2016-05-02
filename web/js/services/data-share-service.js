(function() {
  'use strict';

  angular
    .module('VoidApp')
    .factory('DataShareService', DataShareService);
 
  function DataShareService(){
    var service = {};

    service.globals = {};
    service.setGlobal = setGlobal;
    service.getGlobal = getGlobal;
    service.user    = {};
    service.resetUser = resetUser;
    service.setUser   = setUser;
    service.getUser   = getUser;
 
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
  }
})();