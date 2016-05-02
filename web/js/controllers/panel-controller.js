'use strict';

angular
  .module('VoidApp')
  .controller('PanelController', PanelController);

PanelController.$inject = ['$location', 'AuthenticationService', 'DataShareService', 'APIService'];
function PanelController($location, AuthenticationService, DataShareService, APIService){
  console.log('PanelController');

  var vm = this;
  vm.info_list = [];

  APIService.GetSystem(DataShareService.getUser().last_save_point, function(response){
    vm.info_list = response.list;
  });
  
  vm.info_list = [
    {
      last: false,
      label: 'Sistema:',
      value: 'DVS-123'
    },
    {
      last: false,
      label: 'Créditos:',
      value: 5000
    },
    {
      last: false,
      label: 'Tipo de estrella:',
      value: 'K-IV'
    },
    {
      last: false,
      label: 'Integridad nave:',
      value: '87%'
    },
    {
      last: false,
      label: 'Num. planetas:',
      value: 8
    },
    {
      last: false,
      label: 'Combustible:',
      value: '50%'
    },
    {
      last: true,
      label: 'Exploradores:',
      value: 1
    },
    {
      last: true,
      label: 'Comerciantes:',
      value: 2
    }
  ];

  DataShareService.setGlobal('tab','main');
}