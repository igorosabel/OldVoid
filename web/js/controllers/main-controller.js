'use strict';

angular
  .module('VoidApp')
  .controller('MainController', MainController);

MainController.$inject = ['$location', 'AuthenticationService'];
function MainController($location, AuthenticationService){
  console.log('MainController');
  
  if (!angular.voidgame || !angular.voidgame.user){
    AuthenticationService.ClearCredentials();
    $location.path('/');
    return false;
  }
  
  var vm = this;
}