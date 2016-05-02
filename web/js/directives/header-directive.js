angular
.module('VoidApp')
.directive('header', function() {
  return {
    restrict: 'A',
    templateUrl: 'partials/header.html',
    scope: true,
    transclude : false,
    controller: 'HeaderController',
    controllerAs: 'vm'
  };
});