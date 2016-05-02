angular
.module('VoidApp')
.directive('panel', function() {
  return {
    restrict: 'A',
    templateUrl: 'partials/panel.html',
    scope: true,
    transclude : false,
    controller: 'PanelController',
    controllerAs: 'vm'
  };
});