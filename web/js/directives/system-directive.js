(function(){
  angular
  .module('VoidApp')
  .directive('system', function() {
    return {
      restrict: 'E',
      templateUrl: 'partials/system.html',
      scope: true,
      transclude : false,
      controller: 'SystemController',
      controllerAs: 'vm'
    };
  });
})();