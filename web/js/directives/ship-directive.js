(function(){
  angular
  .module('VoidApp')
  .directive('ship', function() {
    return {
      restrict: 'E',
      templateUrl: 'partials/ship.html',
      scope: true,
      transclude : false,
      controller: 'ShipController',
      controllerAs: 'vm'
    };
  });
})();