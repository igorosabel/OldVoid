(function(){
  angular
  .module('VoidApp')
  .directive('system', function() {
    return {
      restrict: 'A',
      templateUrl: 'partials/system.html',
      scope: true,
      transclude : false,
      controller: 'SystemController',
      controllerAs: 'vm'
    };
  });
})();