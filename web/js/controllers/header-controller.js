'use strict';

angular
  .module('VoidApp')
  .controller('HeaderController', HeaderController);

HeaderController.$inject = ['$location', 'AuthenticationService', 'DataShareService'];
function HeaderController($location, AuthenticationService, DataShareService){
  console.log('HeaderController');
    
  var vm = this;
  vm.explorer_name = DataShareService.getUser().name;
  DataShareService.setGlobal('tab','main');
  vm.tab = DataShareService.globals.tab;
}