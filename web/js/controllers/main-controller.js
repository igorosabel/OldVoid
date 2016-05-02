'use strict';

angular
  .module('VoidApp')
  .controller('MainController', MainController);

MainController.$inject = ['$location', 'AuthenticationService'];
function MainController($location, AuthenticationService){
  console.log('MainController');
  
  if (AuthenticationService.loadLocalStorage() && (!angular.voidgame || !angular.voidgame.user)){
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