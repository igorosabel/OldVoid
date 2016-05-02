'use strict';

angular
  .module('VoidApp')
  .controller('SystemController', SystemController);

SystemController.$inject = ['$location', 'AuthenticationService'];
function SystemController($location, AuthenticationService){
  console.log('SystemController');

  var vm = this;
}