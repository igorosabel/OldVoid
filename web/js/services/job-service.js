(function(){
  'use strict';

  angular
    .module('VoidApp')
    .factory('JobService', JobService);

  JobService.$inject = ['$http','$location','APIService','DataShareService'];
  function JobService($http,$location,APIService,DataShareService){
    var service = {};
 
    return service;
  }
})();