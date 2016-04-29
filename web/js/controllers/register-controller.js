'use strict';

// !Register Controller
// **********************************************************************************************************************************
angular
  .module('VoidApp')
  .controller('RegisterController', RegisterController);

RegisterController.$inject = ['$location', 'AuthenticationService'];
function RegisterController($location, AuthenticationService){
  console.log('RegisterController');
}
/*********************************************************************************************************************************/