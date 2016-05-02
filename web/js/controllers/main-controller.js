'use strict';

angular
  .module('VoidApp')
  .controller('MainController', MainController);

MainController.$inject = ['$location', 'AuthenticationService', 'DataShareService'];
function MainController($location, AuthenticationService, DataShareService){
  console.log('MainController');
  
  if (AuthenticationService.loadLocalStorage() && !DataShareService.getUser()){
    AuthenticationService.ClearCredentials();
    $location.path('/');
    return false;
  }
  
  var vm = this;
  vm.tab = {
    main: true,
    system: false
  };
}